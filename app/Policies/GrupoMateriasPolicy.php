<?php

namespace App\Policies;

use App\Models\Grupo_Materias;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GrupoMateriasPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grupo_Materias  $grupoMaterias
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Grupo_Materias $grupoMaterias)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grupo_Materias  $grupoMaterias
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Grupo_Materias $grupoMaterias)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grupo_Materias  $grupoMaterias
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Grupo_Materias $grupoMaterias)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grupo_Materias  $grupoMaterias
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Grupo_Materias $grupoMaterias)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grupo_Materias  $grupoMaterias
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Grupo_Materias $grupoMaterias)
    {
        //
    }
}
