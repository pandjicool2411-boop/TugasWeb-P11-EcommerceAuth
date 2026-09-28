<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Admin boleh melakukan apa saja
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return true;
    }

    // Hanya editor yang boleh bikin post
    public function create(User $user): bool
    {
        return $user->role === 'editor';
    }

    // Editor hanya boleh edit post miliknya sendiri
    public function update(User $user, Post $post): bool
    {
        return $user->role === 'editor' && $user->id === $post->user_id;
    }

    // Editor hanya boleh hapus post miliknya sendiri
    public function delete(User $user, Post $post): bool
    {
        return $user->role === 'editor' && $user->id === $post->user_id;
    }
}