<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Item $item)
    {
        return $user->id === $item->user_id || $user->is_admin;
    }

    public function update(User $user, Item $item)
    {
        return $user->id === $item->user_id || $user->is_admin;
    }

    public function delete(User $user, Item $item)
    {
        return $user->id === $item->user_id || $user->is_admin;
    }
}
