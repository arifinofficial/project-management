<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'job_id',
        'name',
        'progress',
    ];

    /**
     * Has many relation to tasks table
     *
     * @return void
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
