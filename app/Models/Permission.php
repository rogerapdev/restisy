<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['action', 'name', 'description', 'resource_id', 'active'];

    /**
     * The attributes that cannot be updated.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The roles that have the permission.
     *
     * @return Collection
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_permissions', 'permission_id', 'role_id');
    }

    /**
     * A permission always belongs to a resource.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resource()
    {
        return $this->belongsTo('App\Models\Resource', 'resource_id', 'id');
    }

}
