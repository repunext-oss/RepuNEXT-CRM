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
                'receiver_id' => 'required|exists:users,id'
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
                'receiver_id' => 'required|exists:users,id',
                'message' => 'nullable|string|max:1000',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,mp4,avi,mov|max:10240',
                'voice_message' => 'nullable|file|mimes:wav,mp3,ogg,webm,m4a|max:10240'
            ]);

            $outgoing_id = Auth::id();
            $incoming_id = $request->receiver_id;
            $message = $request->message;

            $attachmentName = null;
            
            // Handle regular file attachments
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentName = time() . '_' . $attachment->getClientOriginalName();
                $attachment->move(public_path('uploads/chat'), $attachmentName);
            }
            
            // Handle voice messages
            if ($request->hasFile('voice_message')) {
                $voiceMessage = $request->file('voice_message');
                $voiceFileName = 'voice_' . time() . '_' . $voiceMessage->getClientOriginalName();
                $voiceMessage->move(public_path('uploads/chat'), $voiceFileName);
                $attachmentName = $voiceFileName; // Store voice file as attachment
                $message = $message ?: '[Voice Message]'; // Set default message for voice
            }

            // Ensure we have either a message or an attachment
            if (!$message && !$attachmentName) {
                return response()->json([
                    'success' => false,
                    'error' => 'Message or attachment is required'
                ], 400);
            }

            $chatMessage = new ChatApp();
            $chatMessage->outgoing_msg_id = $outgoing_id;
            $chatMessage->incoming_msg_id = $incoming_id;
            $chatMessage->msg = $message;
            $chatMessage->attach = $attachmentName;
            $chatMessage->status = 0;
            $chatMessage->isdeleted = 0;
            $chatMessage->save();

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $chatMessage->id,
                    'msg' => $chatMessage->msg,
                    'outgoing_msg_id' => $chatMessage->outgoing_msg_id,
                    'incoming_msg_id' => $chatMessage->incoming_msg_id,
                    'created_at' => $chatMessage->created_at->toISOString(),
                    'attach' => $chatMessage->attach
                ]
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
                'receiver_id' => 'required|exists:users,id'
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
                'receiver_id' => 'required|exists:users,id'
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

    /**
     * Get messages between current user and specified user
     */
    public function getMessages($userId)
    {
        try {
            $currentUserId = Auth::id();
            
            $messages = ChatApp::where('isdeleted', 0)
                ->where(function ($query) use ($currentUserId, $userId) {
                    $query->where('outgoing_msg_id', $currentUserId)
                          ->where('incoming_msg_id', $userId);
                })
                ->orWhere(function ($query) use ($currentUserId, $userId) {
                    $query->where('outgoing_msg_id', $userId)
                          ->where('incoming_msg_id', $currentUserId);
                })
                ->orderBy('created_at', 'ASC')
                ->get()
                ->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'message' => $message->msg,
                        'sender_id' => $message->outgoing_msg_id,
                        'receiver_id' => $message->incoming_msg_id,
                        'created_at' => $message->created_at,
                        'attachment' => $message->attach
                    ];
                });

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);

        } catch (\Exception $e) {
            \Log::error('Get messages error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch messages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get latest messages for real-time updates
     */
    public function getLatestMessages($userId)
    {
        try {
            $currentUserId = Auth::id();
            
            $messages = ChatApp::where('isdeleted', 0)
                ->where(function ($query) use ($currentUserId, $userId) {
                    $query->where('outgoing_msg_id', $currentUserId)
                          ->where('incoming_msg_id', $userId);
                })
                ->orWhere(function ($query) use ($currentUserId, $userId) {
                    $query->where('outgoing_msg_id', $userId)
                          ->where('incoming_msg_id', $currentUserId);
                })
                ->where('created_at', '>', now()->subMinutes(5)) // Get messages from last 5 minutes
                ->orderBy('created_at', 'ASC')
                ->get()
                ->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'message' => $message->msg,
                        'sender_id' => $message->outgoing_msg_id,
                        'receiver_id' => $message->incoming_msg_id,
                        'created_at' => $message->created_at,
                        'attachment' => $message->attach
                    ];
                });

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);

        } catch (\Exception $e) {
            \Log::error('Get latest messages error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch latest messages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get conversations list with last messages
     */
    public function getConversations()
    {
        try {
            $currentUserId = Auth::id();
            \Log::info('Getting conversations for user: ' . $currentUserId);
            
            // Get all users that have conversations with current user
            $conversationUsers = ChatApp::where('isdeleted', 0)
                ->where(function ($query) use ($currentUserId) {
                    $query->where('outgoing_msg_id', $currentUserId)
                          ->orWhere('incoming_msg_id', $currentUserId);
                })
                ->with(['outgoingUser', 'incomingUser'])
                ->get()
                ->groupBy(function ($message) use ($currentUserId) {
                    return $message->outgoing_msg_id == $currentUserId 
                        ? $message->incoming_msg_id 
                        : $message->outgoing_msg_id;
                });

            \Log::info('Found conversation groups: ' . $conversationUsers->count());
            $conversations = [];
            
            foreach ($conversationUsers as $userId => $messages) {
                $user = User::find($userId);
                if ($user) {
                    $lastMessage = $messages->sortByDesc('created_at')->first();
                    $unreadCount = $messages->where('incoming_msg_id', $currentUserId)
                                          ->where('status', 0)
                                          ->count();
                    
                    $conversations[] = [
                        'user_id' => $userId,
                        'user_name' => $user->name,
                        'user_image' => $user->profile_image,
                        'last_message' => $lastMessage ? [
                            'message' => $lastMessage->msg,
                            'created_at' => $lastMessage->created_at
                        ] : null,
                        'unread_count' => $unreadCount
                    ];
                }
            }

            \Log::info('Returning conversations: ' . count($conversations));
            return response()->json([
                'success' => true,
                'conversations' => $conversations
            ]);

        } catch (\Exception $e) {
            \Log::error('Get conversations error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch conversations: ' . $e->getMessage()
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
