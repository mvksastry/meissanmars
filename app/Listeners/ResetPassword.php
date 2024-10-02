<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\PasswordResetSuccess;

class ResetPassword
{
    /**
     * Create the event listener.
     */
    public function __construct(PasswordResetSuccess $event)
    {
        //
				$user_email = $event->user_email;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
