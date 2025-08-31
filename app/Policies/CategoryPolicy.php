<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Category $category)
    {
        return $user->id === $category->user_id || $user->is_admin;
    }

    public function update(User $user, Category $category)
    {
        return $user->id === $category->user_id || $user->is_admin;
    }

    public function delete(User $user, Category $category)
    {
        return $user->id === $category->user_id || $user->is_admin;
    }
}
