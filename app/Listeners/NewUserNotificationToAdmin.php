<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\NewUserNotificationMail;
use App\Mail\SendConfirmationUserCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewUserNotificationToAdmin implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $administrators = User::select('email')->where('role', 'administrator')
        ->where('active', true)->get();

        Mail::to($administrators->pluck('email'))->send(new NewUserNotificationMail($event->user));
    }
}
