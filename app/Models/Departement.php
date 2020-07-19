<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id',
        'user_id',
        'job_id',
        'name',
        'progress',
    ];

    protected $hidden = array('pivot');

    /**
     * Has many relation to tasks table
     *
     * @return void
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Many to many to users table
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Reverse
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Reverse
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
