<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\FeedbackReply;

class UserFeedbackController extends Controller
{
    // Get all messages (user + admin replies)
    public function getMessages(Request $request)
    {
        $username = session('username');
        if (!$username) {
            return response()->json(['error' => 'Not logged in'], 401);
        }

        $feedback = Feedback::where('username', $username)
            ->with('replies')
            ->orderBy('created_at', 'asc')
            ->get();

        $messages = [];

        foreach ($feedback as $f) {
            // main feedback
            $messages[] = [
                'id' => $f->id,
                'sender' => 'user',
                'message' => $f->message,
                'created_at' => $f->created_at->toDateTimeString(),
            ];

            // replies
            foreach ($f->replies as $reply) {
                $messages[] = [
                    'id' => $reply->id,
                    'sender' => $reply->sender, // 'admin' or username
                    'message' => $reply->message,
                    'created_at' => $reply->created_at->toDateTimeString(),
                ];
            }
        }

        // sort by time
        usort($messages, fn($a, $b) => strtotime($a['created_at']) <=> strtotime($b['created_at']));

        return response()->json($messages);
    }

    // Send a message from the user
    public function send(Request $request)
    {
        $username = session('username');
        if (!$username) {
            return response()->json(['error' => 'Not logged in'], 401);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $feedback = Feedback::create([
            'username' => $username,
            'message' => $request->message,
            'sender' => 'user',
        ]);

        return response()->json(['success' => true, 'message' => 'Message sent!']);
    }
}
