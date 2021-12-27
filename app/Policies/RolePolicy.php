<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->getRelationValue('roles')->contains('id', 1)) {
            return true;
        }
        return null;
    }

    public function create(User $user): bool
    {
        return $user->getRelationValue('roles')->contains('id', 2);
    }

    public function update(User $user): bool
    {
        return $user->getRelationValue('roles')->contains('id', 3);
    }

    public function delete(?User $user): bool
    {
        return false;
    }
}
