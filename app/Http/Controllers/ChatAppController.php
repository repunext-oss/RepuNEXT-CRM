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
        $outgoing_id = Auth::id();
        $incoming_id = $request->incoming_id;

        $messages = ChatApp::where('isdeleted', 0)
            ->where(function ($query) use ($outgoing_id, $incoming_id) {
                $query->where('outgoing_msg_id', $outgoing_id)
                      ->where('incoming_msg_id', $incoming_id);
            })
            ->orWhere(function ($query) use ($outgoing_id, $incoming_id) {
                $query->where('outgoing_msg_id', $incoming_id)
                      ->where('incoming_msg_id', $outgoing_id);
            })
            ->orderBy('id', 'ASC')
            ->get()
            ->map(function ($message) {
                $message->outgoing_user = User::find($message->outgoing_msg_id, ['name', 'profile_image']);
                $message->incoming_user = User::find($message->incoming_msg_id, ['name', 'profile_image']);

                return $message;
            });

        return response()->json($messages);
    }
    
    public function sendMessage(Request $request)
    {
        $outgoing_id = Auth::id();
        $incoming_id = $request->incoming_id;
        $message = $request->message;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentName = time() . '_' . $attachment->getClientOriginalName();
            $attachment->move(public_path('uploads/chat'), $attachmentName);
        }

        $chatMessage = new ChatApp();
        $chatMessage->outgoing_msg_id = $outgoing_id;
        $chatMessage->incoming_msg_id = $incoming_id;
        $chatMessage->msg = $message;
        $chatMessage->attach = isset($attachmentName) ? $attachmentName : null;
        $chatMessage->save();
        return response()->json(['success' => true]);
    }
     
    public function deleteMessage(Request $request)
    {
        $messageId = $request->message_id;
        $message = ChatApp::find($messageId);

        if ($message && $message->outgoing_msg_id == Auth::id()) {
            $message->isdeleted = 1;
            $message->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
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
