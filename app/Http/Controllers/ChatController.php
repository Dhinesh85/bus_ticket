<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->get()
            ->map(function($user) {
                // Get latest message between current user and this user
                $latestMessage = Message::where(function($query) use ($user) {
                    $query->where('sender_id', Auth::id())
                          ->where('receiver_id', $user->id);
                })->orWhere(function($query) use ($user) {
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', Auth::id());
                })
                ->latest()
                ->first();
                
                $user->last_message_time = $latestMessage ? $latestMessage->created_at : null;
                $user->last_message_preview = $latestMessage ? Str::limit($latestMessage->message, 25) : 'No messages yet';
                
                return $user;
            });
            
        return view('chat-box', compact('users'));
    }

    public function fetchMessages(Request $request)
    {
        return Message::where(function ($q) use ($request) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('sender_id', $request->receiver_id)
              ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();
    }

    public function sendMessage(Request $request)
    {
        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($msg);
    }
    
    public function getLastMessage(Request $request)
    {
        $userId = $request->user_id;
        
        $latestMessage = Message::where(function($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
        })
        ->latest()
        ->first();
        
        if ($latestMessage) {
            return [
                'time' => $latestMessage->created_at->format('g:i A'),
                'preview' => Str::limit($latestMessage->message, 25)
            ];
        }
        
        return ['time' => '', 'preview' => 'No messages yet'];
    }

    public function uploadAttachment(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'receiver_id' => 'required'
        ]);
        
        // Store the file
        $path = $request->file('file')->store('chat_attachments', 'public');
        
        // Create a message with file info
        $fileName = $request->file('file')->getClientOriginalName();
        $message = "Sent an attachment: " . $fileName;
        
        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $message,
            'attachment' => $path
        ]);
        
        return response()->json($msg);
    }
}