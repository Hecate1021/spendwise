<?php

namespace App\Console\Commands;

use App\Models\Goal;
use App\Models\User;
use App\Mail\GoalReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendGoalReminders extends Command
{
    protected $signature = 'goals:send-reminders';
    protected $description = 'Send email reminders for goals reaching their aim date';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        // Find all goals with today's date and not yet completed
        $goals = Goal::whereDate('aim_date', $today)
                     ->where('is_completed', false)
                     ->get();

        if ($goals->isEmpty()) {
            $this->info("No goals due today.");
            return 0;
        }

        foreach ($goals as $goal) {
            // Find the matching user by username
            $user = User::where('username', $goal->user)->first();

            if ($user && $user->email) {
                try {
                    Mail::to($user->email)->send(new GoalReminderMail($goal));
                    $this->info("✅ Reminder sent to {$user->email} for goal '{$goal->title}'");
                    Log::info("✅ Reminder sent to {$user->email} for goal '{$goal->title}'");
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
