<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
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
        'name', 'label', 'order'
    ];

    /**
     * Tasks thas has currentlly this status defined
     *
     * @return void
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
