<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UploadServer;
use Illuminate\Auth\Access\HandlesAuthorization;

class UploadServerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_upload::server');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UploadServer $uploadServer): bool
    {
        return $user->can('view_upload::server');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_upload::server');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UploadServer $uploadServer): bool
    {
        return $user->can('update_upload::server');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UploadServer $uploadServer): bool
    {
        return $user->can('delete_upload::server');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_upload::server');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, UploadServer $uploadServer): bool
    {
        return $user->can('force_delete_upload::server');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_upload::server');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, UploadServer $uploadServer): bool
    {
        return $user->can('restore_upload::server');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_upload::server');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, UploadServer $uploadServer): bool
    {
        return $user->can('replicate_upload::server');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_upload::server');
    }
}
