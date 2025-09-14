<?php

namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    
    public function index()
    {
        $rooms = Room::where('r_isdeleted', 0)->orderBy('id','DESC')->get();
        $users = User::all();
        return view('chat.index', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $room = Room::create([
            'name' => $request->name
        ]);

        $room->users()->attach($request->users);

        if (!in_array(auth()->id(), $request->users)) {
            $room->users()->attach(auth()->id());
        }

        return redirect()->route('chat.show', $room->id)->with('success', 'Room created and users added.');
    }



    // Show chat room with messages
    public function show($id)
    {
        $room = Room::with('users')->findOrFail($id);

        // Restrict access: only allow members
        if (!$room->users->contains(auth()->id())) {
            abort(403, 'Unauthorized access to this chat room.');
        }

        $messages = $room->messages()->with('user')->get();

        return view('chat.show', compact('room', 'messages'));
    }


    // Send message to room
    public function sendMessage(Request $request, $roomId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'room_id' => $roomId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $roomId);
    }
    public function addUsers(Request $request, $id)
    {
        $request->validate([
            'users' => 'required|array|min:1',
            'users.*' => 'exists:users,id',
        ]);

        $room = Room::findOrFail($id);

        $room->users()->syncWithoutDetaching($request->users);

        return redirect()->route('chat.shows', $room->id)->with('success', 'Users added successfully.');
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
        $room->r_isdeleted     =   "1";
        $room->save();   
    
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

}
