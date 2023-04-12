<?php

namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    public function update(User $user, DatabaseNotification $databaseNotification): Response
    {
        return $user->id === $databaseNotification->notifiable_id
            ? Response::allow()
            : Response::deny('You do not own this notification');
    }
}
