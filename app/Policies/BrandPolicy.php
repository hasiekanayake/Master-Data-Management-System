<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Brand $brand)
    {
        return $user->id === $brand->user_id || $user->is_admin;
    }

    public function update(User $user, Brand $brand)
    {
        return $user->id === $brand->user_id || $user->is_admin;
    }

    public function delete(User $user, Brand $brand)
    {
        return $user->id === $brand->user_id || $user->is_admin;
    }
}
