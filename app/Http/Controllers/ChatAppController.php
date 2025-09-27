<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use App\Models\ChatApp;
use App\Models\User;
use Illuminate\Http\Request;

class ChatAppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $users = User::where('status', 0)->where('isdeleted', 0)->get();
       return view('chat_app.list', compact('users'));
    }

    public function fetchMessages(Request $request)
    {
        try {
            $request->validate([
                'incoming_id' => 'required|exists:users,id'
            ]);

            $outgoing_id = Auth::id();
            $incoming_id = $request->incoming_id;
            $last_time = $request->last_time;

            $query = ChatApp::where('isdeleted', 0)
                ->where(function ($query) use ($outgoing_id, $incoming_id) {
                    $query->where('outgoing_msg_id', $outgoing_id)
                          ->where('incoming_msg_id', $incoming_id);
                })
                ->orWhere(function ($query) use ($outgoing_id, $incoming_id) {
                    $query->where('outgoing_msg_id', $incoming_id)
                          ->where('incoming_msg_id', $outgoing_id);
                });

            // If last_time is provided, only fetch messages after that timestamp
            if ($last_time) {
                $query->where('created_at', '>', $last_time);
            }

            $messages = $query->orderBy('id', 'ASC')
                ->get()
                ->map(function ($message) {
                    $message->outgoing_user = User::find($message->outgoing_msg_id, ['name', 'profile_image']);
                    $message->incoming_user = User::find($message->incoming_msg_id, ['name', 'profile_image']);

                    return $message;
                });

            return response()->json($messages);

        } catch (\Exception $e) {
            \Log::error('Fetch messages error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch messages: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'incoming_id' => 'required|exists:users,id',
                'message' => 'nullable|string|max:1000',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,mp4,avi,mov|max:10240'
            ]);

            $outgoing_id = Auth::id();
            $incoming_id = $request->incoming_id;
            $message = $request->message;

            // Check if at least message or attachment is provided
            if (empty($message) && !$request->hasFile('attachment')) {
                return response()->json([
                    'success' => false,
                    'error' => 'Either a message or attachment must be provided.'
                ], 422);
            }

            $attachmentName = null;
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentName = time() . '_' . $attachment->getClientOriginalName();
                $attachment->move(public_path('uploads/chat'), $attachmentName);
            }

            $chatMessage = new ChatApp();
            $chatMessage->outgoing_msg_id = $outgoing_id;
            $chatMessage->incoming_msg_id = $incoming_id;
            $chatMessage->msg = $message ?: null;
            $chatMessage->attach = $attachmentName;
            $chatMessage->status = 0;
            $chatMessage->isdeleted = 0;
            $chatMessage->save();

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Chat message sending error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }
     
    public function deleteMessage(Request $request)
    {
        try {
            $request->validate([
                'message_id' => 'required|exists:chat_messages,id'
            ]);

            $messageId = $request->message_id;
            $message = ChatApp::find($messageId);

            if (!$message) {
                return response()->json([
                    'success' => false,
                    'error' => 'Message not found'
                ], 404);
            }

            // Check if user is authorized to delete this message
            if ($message->outgoing_msg_id != Auth::id()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized to delete this message'
                ], 403);
            }

            $message->isdeleted = 1;
            $message->save();

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Delete message error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete message: ' . $e->getMessage()
            ], 500);
        }
    }


    public function typing(Request $request)
    {
        try {
            $request->validate([
                'incoming_id' => 'required|exists:users,id'
            ]);

            // In a real-time chat application, you would broadcast this event
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'typing' => true,
                'user_id' => Auth::id()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to update typing status'
            ], 500);
        }
    }

    public function stoppedTyping(Request $request)
    {
        try {
            $request->validate([
                'incoming_id' => 'required|exists:users,id'
            ]);

            // In a real-time chat application, you would broadcast this event
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'typing' => false,
                'user_id' => Auth::id()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to update typing status'
            ], 500);
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ChatApp $chatApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatApp $chatApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatApp $chatApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatApp $chatApp)
    {
        //
    }
}
