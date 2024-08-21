<?php

namespace App\Listeners;

class AuthChanged
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event instanceof \Illuminate\Auth\Events\Login) {
            \App\Helpers\Auth::setGuard($event->guard);
        } elseif ($event instanceof \Illuminate\Auth\Events\Logout) {
            \App\Helpers\Auth::setGuard(null);
        }
    }
}
