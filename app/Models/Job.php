<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Job extends Model
{
    use SoftDeletes, Searchable;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start',
        'end',
        'progress',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /**
     * Search
     *
     * @return void
     */
    public function searchableAs()
    {
        return 'jobs_index';
    }

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskCount()
    {
        $total = 0;
        foreach ($this->departements as $departement) {
            $total += count($departement->tasks);
        }
        
        return $total;
    }
}
