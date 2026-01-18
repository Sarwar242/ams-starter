<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any departments.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view departments list
        return true;
    }

    /**
     * Determine whether the user can view the department.
     */
    public function view(User $user, Department $department): bool
    {
        // All authenticated users can view a department
        return true;
    }

    /**
     * Determine whether the user can create departments.
     */
    public function create(User $user): bool
    {
        // Only admin and leader can create departments
        //return in_array($user->role, ['admin', 'leader']);

        return auth()->id()==$user->id;
    }

    /**
     * Determine whether the user can update the department.
     */
    public function update(User $user, Department $department): bool
    {
        // Only admin and leader can update departments
        // return in_array($user->role, ['admin', 'leader']);

        return auth()->id()==$user->id;
    }

    /**
     * Determine whether the user can delete the department.
     */
    public function delete(User $user, Department $department): bool
    {
        // Only admin can delete departments
        // return $user->role === 'admin';
        return auth()->id()==$user->id;
    }

    /**
     * Determine whether the user can restore the department.
     */
    public function restore(User $user, Department $department): bool
    {
        return auth()->id()==$user->id;
    }

    /**
     * Determine whether the user can permanently delete the department.
     */
    public function forceDelete(User $user, Department $department): bool
    {
        return auth()->id()==$user->id;
    }
}
