<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Goal;
use App\Models\User;
use App\Mail\GoalReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendGoalReminders extends Command
{
    protected $signature = 'goals:send-reminders';
    protected $description = 'Send email reminders for goals reaching their aim date';

    public function handle()
    {
        // Check for goals due today and tomorrow
        $dates = [
            Carbon::today()->toDateString(),
            Carbon::tomorrow()->toDateString(),
        ];

        $goals = Goal::whereIn('aim_date', $dates)
                     ->where('is_completed', false)
                     ->get();

        if ($goals->isEmpty()) {
            $this->info("No goals due today or tomorrow.");
            return 0;
        }

        foreach ($goals as $goal) {
            // Get the user by username
            $user = User::where('username', $goal->user)->first();

            if ($user && $user->email) {
                // Determine if the reminder is for today or tomorrow
                $when = ($goal->aim_date == Carbon::today()->toDateString()) ? 'today' : 'tomorrow';

                try {
                    Mail::to($user->email)->send(new GoalReminderMail($goal, $when));

                    $this->info("✅ Reminder sent to {$user->email} for goal '{$goal->title}' ({$when})");
                    Log::info("✅ Reminder sent to {$user->email} for goal '{$goal->title}' ({$when})");
                } catch (\Exception $e) {
                    $this->error("❌ Failed to send to {$user->email}: " . $e->getMessage());
                    Log::error("❌ Failed to send reminder for {$goal->title}: " . $e->getMessage());
                }
            } else {
                $this->warn("⚠️ No email found for user '{$goal->user}'");
                Log::warning("⚠️ No email found for user '{$goal->user}'");
            }
        }

        return 0;
    }
}
