<?php

namespace App\Policies;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BarangPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->can('melihat barang')) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to view barang.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Barang $barang): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->can('membuat barang')) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to create barang.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Barang $barang): Response
    {
        if ($user->can('update barang')) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to update barang.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Barang $barang): Response
    {
        if ($user->can('hapus barang')) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to delete barang.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Barang $barang): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Barang $barang): bool
    {
        return false;
    }
}
