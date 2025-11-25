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
    public $when;

    public function __construct(Goal $goal, string $when)
    {
        $this->goal = $goal;
        $this->when = $when; // today or tomorrow
    }

    public function build()
    {
        return $this->subject("🎯 Goal Reminder: {$this->goal->title}")
                    ->view('emails.goal-reminder')
                    ->with([
                        'goalTitle' => $this->goal->title,
                        'goalDate' => \Carbon\Carbon::parse($this->goal->aim_date)->format('F j, Y'),
                        'goalDescription' => $this->goal->description,
                        'goalTarget' => number_format($this->goal->target_amount, 2),
                        'goalUser' => $this->goal->user,
                        'when' => $this->when,
                    ]);
    }
}
