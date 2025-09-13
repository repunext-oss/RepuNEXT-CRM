<?php

namespace App\Http\Controllers;
use App\Models\Message;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'message'    => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,docx,mp4|max:20480', // Max 20MB
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        Message::create([
            'room_id'   => $request->room_id,
            'user_id'   => auth()->id(),
            'message'   => $request->message,
            'attachment' => $attachmentPath, 
        ]);

        return redirect()->back()->with('success', 'Message sent!');
    }
    public function destroy($id)
    {
        $room = Message::findOrFail($id);
        $room->is_deleted = "1";
        $room->save();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('rooms.index');
    }
}

