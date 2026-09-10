<?php

namespace App\Policies;

use App\Models\StudentProfile;
use App\Models\User;

class StudentProfilePolicy
{
    /**
     * Determine whether the user can view the student profile.
     */
    public function view(User $user, StudentProfile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can update the student profile.
     */
    public function update(User $user, StudentProfile $profile): bool
    {
        return $user->id === $profile->user_id;
    }
}
