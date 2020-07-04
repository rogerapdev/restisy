<?php namespace App\Repositories;

use App\Criteria\TenantCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class Repository extends BaseRepository
{

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return "";
    }

    public function makeModelWith()
    {
        return $this->makeModel();
    }

}
