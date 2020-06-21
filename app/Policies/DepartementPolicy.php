<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Job;
use App\Models\Departement;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartementPolicy
{
    use HandlesAuthorization;

    public function createDepartement(User $user, Job $job)
    {
        return $user->can('create new departement');
    }

    public function showModal(User $user, Departement $departement)
    {
        return $user->can('update job') && in_array($user->id, $departement->users->pluck('id')->toArray());
    }
}
