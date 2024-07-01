<?php

namespace App\Console\Commands;

use App\Mail\TemplateDeadlineReminder;
use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders 24 hours before template deadlines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $templates = Template::where('deadline', '>=', Carbon::now())
            ->where('deadline', '<=', Carbon::now()->addDay())
            ->where('users_notified', false)
            ->get();

        foreach ($templates as $template) {
            $users = User::where('type', '!=', 1)->get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new TemplateDeadlineReminder($template, $user));
            }

            // Update the template's users_notified field to true
            $template->users_notified = true;
            $template->save();
        }

        $this->info('Template deadline reminders sent successfully.');
    }
}
