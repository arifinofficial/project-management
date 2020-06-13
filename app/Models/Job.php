<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start',
        'end',
    ];

    /**
     * Has many relation to departements table
     *
     * @return void
     */
    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    /**
     * Many to many relation to categories table
     *
     * @return void
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
