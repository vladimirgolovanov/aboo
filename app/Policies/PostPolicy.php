<?php

namespace App\Policies;

use App\User;
use App\Post;

class PostPolicy
{
    public function edit(User $user, Post $post)
    {
        return $user->id === $post->postGroup()->first()->user_id;
    }
}
