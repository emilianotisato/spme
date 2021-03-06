<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    /**
     * Disabling eloquent timestamps
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'label', 'level'
    ];

    /**
     * Tasks thas has currentlly this severity defined
     *
     * @return void
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
