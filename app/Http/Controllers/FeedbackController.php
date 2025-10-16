<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackReply;
use Illuminate\Http\Request;
use App\Models\User;

class FeedbackController extends Controller
{
    public function index()
    {
        // ✅ Get all users who have feedback (using username relationship)
        $users = User::whereHas('feedbacks')->withCount('feedbacks')->get();

        return view('admin.feedback-list', [
            'page' => 'User Feedback',
            'users' => $users,
        ]);
    }

    public function show(User $user)
    {
        // ✅ Fetch feedbacks using username instead of user_id
        $feedbacks = Feedback::where('username', $user->username)
            ->with('replies')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.feedback-show', [
            'page' => $user->username . "'s Feedback",
            'user' => $user,
            'feedbacks' => $feedbacks,
        ]);
    }

    public function reply(Request $request, Feedback $feedback)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        FeedbackReply::create([
            'feedback_id' => $feedback->id,
            'sender' => 'admin',
            'message' => $request->message,
        ]);

        return back()->with('success', 'Reply sent successfully!');
    }

    public function userMessages()
{
    $username = session('username');

    // Get all messages (user feedback + admin replies)
    $feedbacks = Feedback::where('username', $username)
        ->with('replies')
        ->orderBy('created_at', 'asc')
        ->get();

    $messages = [];

    foreach ($feedbacks as $f) {
        $messages[] = [
            'id' => $f->id,
            'message' => $f->message,
            'sender' => $f->sender,
            'created_at' => $f->created_at,
        ];

        foreach ($f->replies as $r) {
            $messages[] = [
                'id' => $r->id,
                'message' => $r->message,
                'sender' => $r->sender,
                'created_at' => $r->created_at,
            ];
        }
    }

    // Sort all messages by time
    usort($messages, fn($a, $b) => strtotime($a['created_at']) - strtotime($b['created_at']));

    return response()->json($messages);
}


public function userSend(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    $username = session('username');

    // Save feedback as user message
    $feedback = Feedback::create([
        'username' => $username,
        'message' => $request->message,
        'sender' => 'user',
    ]);

    // Optional: auto reply
    FeedbackReply::create([
        'feedback_id' => $feedback->id,
        'sender' => 'admin',
        'message' => 'Thank you for your feedback! We appreciate your input.',
    ]);

    return response()->json(['success' => true]);
}
}
