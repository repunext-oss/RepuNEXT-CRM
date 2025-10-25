<?php

namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    
    public function index()
    {
        $rooms = Room::active()
            ->with(['users', 'latestMessage.user'])
            ->whereHas('users', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('updated_at', 'DESC')
            ->get();
            
        $users = User::where('status', 0)->get();
        return view('chat.index', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'room_type' => 'nullable|in:general,project,department',
            'users' => 'required|array|min:1',
            'users.*' => 'exists:users,id',
        ]);

        $room = Room::create([
            'name' => $request->name,
            'description' => $request->description,
            'room_type' => $request->room_type ?? 'general',
            'created_by' => auth()->id(),
            'is_active' => true,
            'r_isdeleted' => false
        ]);

        // Add selected users
        $room->users()->attach($request->users);

        // Add creator if not already in the list
        if (!in_array(auth()->id(), $request->users)) {
            $room->users()->attach(auth()->id());
        }

        return redirect()->route('chat.show', $room->id)->with('success', 'Room created successfully!');
    }



    // Show chat room with messages
    public function show($id)
    {
        $room = Room::with(['users', 'creator'])->findOrFail($id);

        // Restrict access: only allow members
        if (!$room->users->contains(auth()->id())) {
            abort(403, 'Unauthorized access to this chat room.');
        }

        $messages = $room->messages()
            ->active()
            ->with(['user', 'replyTo.user'])
            ->orderBy('created_at', 'asc')
            ->get();

        $users = User::where('status', 0)->get();

        return view('chat.show', compact('room', 'messages', 'users'));
    }

    // Send message to room
    public function sendMessage(Request $request, $roomId)
    {
        try {
            $request->validate([
                'message' => 'nullable|string|max:1000',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,mp4,avi,mov|max:10240',
                'reply_to_message_id' => 'nullable|exists:messages,id'
            ]);

            // Ensure at least one of message or attachment is provided
            if (empty($request->message) && !$request->hasFile('attachment')) {
                return response()->json([
                    'success' => false,
                    'error' => 'Either a message or attachment must be provided.'
                ], 422);
            }

            $room = Room::findOrFail($roomId);

            // Check if user is member of the room
            if (!$room->users->contains(auth()->id())) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $data = [
                'room_id' => $roomId,
                'user_id' => Auth::id(),
                'message' => $request->message ?: null, // Allow null messages for attachments only
                'reply_to_message_id' => $request->reply_to_message_id ?: null,
                'is_deleted' => false
            ];

            // Handle file attachment
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/chat'), $filename);
                
                $data['attachment'] = $filename;
                $data['attachment_type'] = $file->getClientMimeType();
            }

            $message = Message::create($data);
            $message->load(['user', 'replyTo.user']);

            // Update room's updated_at timestamp
            $room->touch();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'html' => view('chat.message', compact('message'))->render()
                ]);
            }

            return redirect()->route('chat.show', $roomId);
        } catch (\Exception $e) {
            \Log::error('Message sending error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to send message: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }
    public function addUsers(Request $request, $id)
    {
        $request->validate([
            'users' => 'required|array|min:1',
            'users.*' => 'exists:users,id',
        ]);

        $room = Room::findOrFail($id);

        // Check if user is a member of the room
        if (!$room->users->contains(auth()->id())) {
            return back()->with('error', 'You must be a member of this room to add other members.');
        }

        $room->users()->syncWithoutDetaching($request->users);

        return redirect()->route('chat.show', $room->id)->with('success', 'Users added successfully.');
    }

    public function removeUser(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $room = Room::findOrFail($id);

        if ($request->user_id == auth()->id()) {
            return redirect()->route('chat.show', $room->id)->with('error', 'You cannot remove yourself.');
        }

        $room->users()->detach($request->user_id);

        return redirect()->route('chat.show', $room->id)->with('success', 'User removed successfully.');
    }
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        
        // Only allow creator or admin to delete room
        if ($room->created_by !== auth()->id()) {
            return redirect()->route('rooms.index')->with('error', 'Only room creator can delete this room.');
        }
        
        $room->update(['r_isdeleted' => true]);
    
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

    // Delete a message
    public function deleteMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Only allow message owner to delete
        if ($message->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $message->update(['is_deleted' => true]);
        
        return response()->json(['success' => true]);
    }

    // Get new messages for real-time updates
    public function getNewMessages($roomId, $lastMessageId = null)
    {
        $room = Room::findOrFail($roomId);
        
        // Check if user is member
        if (!$room->users->contains(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $query = $room->messages()->active()->with(['user', 'replyTo.user']);
        
        if ($lastMessageId) {
            $query->where('id', '>', $lastMessageId);
        }
        
        $messages = $query->orderBy('created_at', 'asc')->get();
        
        return response()->json([
            'messages' => $messages,
            'html' => view('chat.messages', compact('messages'))->render()
        ]);
    }

}
