<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TicketCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketCategoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return $user->is_admin ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(?User $user, TicketCategory $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, TicketCategory $category): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, TicketCategory $category): bool
    {
        return $user->is_admin;
    }
}
