<?php

namespace App\Policies;

use App\User;
use App\PostGroup;

class PostGroupPolicy
{
    public function edit(User $user, PostGroup $postGroup)
    {
        return $user->id === $postGroup->user_id;
    }
}
