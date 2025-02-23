<?php

namespace App\Policies;

use App\Models\Analysis;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnalysisPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, Analysis $analysis): bool
    {
        return ($user->id === $analysis->user_id && $user->hasRole('redactor')) || $user->hasRole('admin');
    }

    public function update(User $user, Analysis $analysis): bool
    {
        return ($user->id === $analysis->user_id && $user->hasRole('redactor')) || $user->hasRole('admin');
    }
}
