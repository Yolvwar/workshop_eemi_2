<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pet;

class PetPolicy
{
    /**
     * Determine if the user can view the pet.
     */
    public function view(User $user, Pet $pet): bool
    {
        return $user->id === $pet->user_id;
    }

    /**
     * Determine if the user can update the pet.
     */
    public function update(User $user, Pet $pet): bool
    {
        return $user->id === $pet->user_id;
    }

    /**
     * Determine if the user can delete the pet.
     */
    public function delete(User $user, Pet $pet): bool
    {
        return $user->id === $pet->user_id;
    }
}
