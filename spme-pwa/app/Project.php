<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'website',
        'notes',
        'secrets'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'secrets' => 'array',
    ];

    /**
     * The client this project belongs to
     *
     * @return void
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * The tasks that belongs to this project
     *
     * @return void
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
