<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'config',
        'notes',
        'secrets'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'array',
        'secrets' => 'array',
    ];

    /**
     * Projects for this client
     *
     * @return void
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
