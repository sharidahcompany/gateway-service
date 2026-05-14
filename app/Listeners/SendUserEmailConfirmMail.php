<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\UserEmailConfirmMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserEmailConfirmMail implements ShouldQueue
{
    public $tries = 5;

    public $backoff = [10, 30, 60];
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
        Mail::to($event->user->email)->send(new UserEmailConfirmMail($event->user));
    }
}
