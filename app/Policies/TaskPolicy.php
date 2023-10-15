<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
        return $user->id === $task->user_id
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }
}
