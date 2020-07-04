<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\RequestGuard;

class Identify extends RequestGuard
{

    /**
     * Check if user is administrator
     */
    public function isAdmin()
    {
        $user = $this->user();
        if ($user) {
            return $this->is('admin') ? true : false;
        }

        return false;
    }


    /**
     * Alias of hasRole().
     *
     * @param  mixed    $roles
     * @param  boolean  $all
     * @return boolean
     */
    public function is($role, $any = false)
    {

        $user = $this->user();
        if ($user) {
            if (!is_array($role)) {
                $role = [$role];
            }

            $cached = json_decode($user->roles_cached, false);
            if(count($cached) == 0){
                $this->cacheRoles();
                $user = User::find($user->id);
                $cached = json_decode($user->roles_cached, false);
            }

            return inArrayAll($role, $cached, $any);
        }
        return false;

    }

    /**
     * Store the currently logged in user's id in session.
     * Log the new user in
     * @param App\Models\User $user
     */
    public function can($permission, $any = false)
    {

        $user = $this->user();
        if ($user) {
            if ($this->is('admin')) {
                return true;
            }

            if (!is_array($permission)) {
                $permission = [$permission];
            }

            $cached = json_decode($user->permissions_cached, false);
            if(count($cached) == 0){
                $this->cachePermissions();
                $user = User::find($user->id);
                $cached = json_decode($user->permissions_cached, false);
            }

            return inArrayAll($permission, $cached, $any);
        }

        return false;

    }

    /**
     * Store the currently logged in user's id in session.
     * Log the new user in
     * @param App\Models\User $user
     */
    public function cacheRoles($id = null)
    {
        $user = $this->user();
        if ($user) {
            if ($id) {
                $user = User::find($id);
            }

            $roles = $user->roles;
            $actions = collect([]);
            if ($roles) {
                foreach ($roles as $key => $role) {
                    $actions->push($role->slug);
                }
            }

            $user->roles_cached = $actions->toJson();
            $user->save();
        }

        return false;

    }

    /**
     * Store the currently logged in user's id in session.
     * Log the new user in
     * @param App\Models\User $user
     */
    public function cachePermissions($id = null)
    {
        $user = $this->user();
        if ($user) {
            if ($id) {
                $user = User::find($id);
            }

            $roles = $user->roles;
            $actions = collect([]);
            if ($roles) {
                foreach ($roles as $key => $role) {

                    $permissions = $role->permissions;
                    if ($permissions) {
                        foreach ($permissions as $key2 => $permission) {
                            $actions->push($permission->action);
                        }
                    }
                }
            }

            $user->permissions_cached = $actions->toJson();
            $user->save();
        }

        return false;
    }

}
