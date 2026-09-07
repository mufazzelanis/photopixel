<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CtaBand;
use Illuminate\Auth\Access\HandlesAuthorization;

class CtaBandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_cta::band');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CtaBand $ctaBand): bool
    {
        return $user->can('view_cta::band');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_cta::band');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CtaBand $ctaBand): bool
    {
        return $user->can('update_cta::band');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CtaBand $ctaBand): bool
    {
        return $user->can('delete_cta::band');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_cta::band');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CtaBand $ctaBand): bool
    {
        return $user->can('force_delete_cta::band');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_cta::band');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, CtaBand $ctaBand): bool
    {
        return $user->can('restore_cta::band');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_cta::band');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CtaBand $ctaBand): bool
    {
        return $user->can('replicate_cta::band');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_cta::band');
    }
}
