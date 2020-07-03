<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * The attributes that cannot be updated.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the comments for the blog post.
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\Permission');
    }
}
