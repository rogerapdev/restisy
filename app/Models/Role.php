<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'active'
    ];

    /**
     * A role may have multiple permissions.
     *
     * @return Collection
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'role_permissions', 'role_id', 'permission_id')->withTimestamps();
    }

    /**
     * A role may have multiple users.
     *
     * @return Collection
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_roles', 'role_id', 'user_id')->withTimestamps();
    }
}
