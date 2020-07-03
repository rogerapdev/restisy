<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\SessionGuard;
use Hasher;

class Identify extends SessionGuard
{

    private $isActiveKey = 'auth.is_user_login';
    private $originalUserKey = 'auth.original_user';

    /**
     * Check if user is administrator
     */
    public function isAdmin()
    {
        $user = $this->user();
        if ($user) {
            return $user->is_admin ? true : false;
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
            if ($user->is_owner) {
                return true;
            }

            if (!is_array($role)) {
                $role = [$role];
            }

            $cached = json_decode($user->roles_cached, false);

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
            if ($user->is_owner) {
                return true;
            }

            if (!is_array($permission)) {
                $permission = [$permission];
            }

            $cached = json_decode($user->permissions_cached, false);
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

    /**
     * Store the currently logged in user's id in session.
     * Log the new user in
     * @param App\Models\User $user
     */
    public function loginUser($user)
    {
        if ($user->is_admin) {
            throw new SysException(trans('messages.auth.unauthorized'));
        }

        // if not impersonated, save current logged in user
        // otherwise do not update (leave first original user in session)
        if (!$this->isUserLogin()) {
            session()->put($this->originalUserKey, auth()->user()->id);
        }
        auth()->loginUsingId($user->id);
        session()->put($this->isActiveKey, true);

    }

    /**
     * Logout the current user
     * Log back in as the orignal user
     * Delete the session
     * @return bool
     */
    public function logoutUser()
    {
        if (!$this->isUserLogin()) {
            return false;
        }
        auth()->logout();
        // log back in as the original user
        $originalUserId = session()->get($this->originalUserKey);
        if ($originalUserId) {
            auth()->loginUsingId($originalUserId);
        }
        session()->forget($this->originalUserKey);
        session()->forget($this->isActiveKey);
        return true;
    }

    /**
     * Is a user currently busy another user
     * @return mixed
     */
    public function isUserLogin()
    {
        return session()->has($this->isActiveKey);
    }

}
