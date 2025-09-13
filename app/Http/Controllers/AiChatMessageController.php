<?php

namespace App\Http\Controllers;

use App\Models\AiChatMessage;
use Illuminate\Http\Request; 
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Auth;

class AiChatMessageController extends Controller
{
    protected $openai;

    public function __construct(OpenAIService $openai)
    {
        $this->openai = $openai;
    } 
    public function index()
    {
        $messages = AiChatMessage::where('user_id', Auth::id())
                                 ->orderBy('id','ASC')
                                 ->get();

        return view('aichat.index', compact('messages'));
    } 
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'categoryname' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $category = $request->input('categoryname');

        $response = $this->openai->chat($userMessage, $category); 
        AiChatMessage::create([
            'user_id' => Auth::id(),
            'user_message' => $userMessage,
            'chatgpt_response' => $response,
            'categoryname' => $category,
        ]);
        $notification = array( 'message' => 'AI response received Successfully', 'alert-type' => 'info' );
        return redirect()->back()->with($notification);
    }
}