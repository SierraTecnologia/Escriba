<?php

namespace Escritor\Http\Policies;

use App\Models\User;

/**
 * Class EscritorPolicy.
 *
 * @package Finder\Http\Policies
 */
class EscritorPolicy
{
    /**
     * Create a escritor.
     *
     * @param  User   $authUser
     * @param  string $escritorClass
     * @return bool
     */
    public function create(User $authUser, string $escritorClass)
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        return false;
    }

    /**
     * Get a escritor.
     *
     * @param  User  $authUser
     * @param  mixed $escritor
     * @return bool
     */
    public function get(User $authUser, $escritor)
    {
        return $this->hasAccessToEscritor($authUser, $escritor);
    }

    /**
     * Determine if an authenticated user has access to a escritor.
     *
     * @param  User $authUser
     * @param  $escritor
     * @return bool
     */
    private function hasAccessToEscritor(User $authUser, $escritor): bool
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        if ($escritor instanceof User && $authUser->id === optional($escritor)->id) {
            return true;
        }

        if ($authUser->id === optional($escritor)->created_by_user_id) {
            return true;
        }

        return false;
    }

    /**
     * Update a escritor.
     *
     * @param  User  $authUser
     * @param  mixed $escritor
     * @return bool
     */
    public function update(User $authUser, $escritor)
    {
        return $this->hasAccessToEscritor($authUser, $escritor);
    }

    /**
     * Delete a escritor.
     *
     * @param  User  $authUser
     * @param  mixed $escritor
     * @return bool
     */
    public function delete(User $authUser, $escritor)
    {
        return $this->hasAccessToEscritor($authUser, $escritor);
    }
}
