<?php namespace App\Repositories;

use App\Repositories\Repository;

class RoleRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return "App\Models\Role";
    }

    public function bySlug($slug)
    {
        $instance = $this->makeModel();
        return $instance->where('slug', $slug)->get();
    }

}
