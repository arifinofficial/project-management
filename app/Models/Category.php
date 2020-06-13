<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Many to many relation to jobs table
     *
     * @return void
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
}
