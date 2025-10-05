<?php

namespace App\Mail;

use App\Models\Goal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GoalReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $goal;

    public function __construct(Goal $goal)
    {
        $this->goal = $goal;
    }

    public function build()
    {
        return $this->subject('🎯 Goal Reminder: ' . $this->goal->title)
                    ->view('emails.goal-reminder');
    }
}
