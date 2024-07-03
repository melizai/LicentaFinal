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
    protected $description = 'Termenul limita pentru template in mai putin de 24h';

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

            $template->users_notified = true;
            $template->save();
        }

        $this->info('Template deadline reminders sent successfully.');
    }
}
