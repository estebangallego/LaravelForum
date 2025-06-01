<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        $user->deleteProfilePhoto();
        // Safely handle token deletion if tokens relationship exists
        if (method_exists($user, 'tokens') && $user->tokens) {
            $user->tokens->each->delete();
        }
        $user->delete();
    }
}
