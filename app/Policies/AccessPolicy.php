<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessPolicy
{
    use HandlesAuthorization;
    public function admin(User $user) {
        return $user->isAdministrator();
    }

    public function empresa(User $user) {
        return $user->isEmpresa();
    }


    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
