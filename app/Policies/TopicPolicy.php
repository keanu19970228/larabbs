<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        return $user->id === $topic->user_id || $user->id === 1;
    }

    public function destroy(User $user, Topic $topic)
    {
        return true;
    }
}
