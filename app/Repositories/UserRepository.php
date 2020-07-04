<?php namespace App\Repositories;

use App\Repositories\Repository;

class UserRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return "App\Models\User";
    }

    public function syncPermissions($permissions, $id)
    {
            $instance = $this->makeModel()->find($id);
            $instance->permissions()->sync($permissions);
    }

    public function syncRoles($roles, $id)
    {
        $instance = $this->makeModel()->find($id);
        $instance->roles()->sync($roles);
    }

}
