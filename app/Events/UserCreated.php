<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $author;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param User $author
     */
    public function __construct(User $user, User $author)
    {
        $this->user = $user;
        $this->author = $author;
    }
}
