<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserActions
{
    /**
     * Handle the event.
     *
     * @param UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;
        $author = $event->author;

        Log::info('User created', ['user' => $user->toArray(), 'author' => $author->toArray(), 'date' => now()]);
    }
}
