<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function disable(User $user): bool
    {
        return $user->isAdmin();
    }

    public function admin(User $user): bool
    {
        return $user->isAdmin();
    }

    public function generally(): bool
    {
        return true;
    }
}
