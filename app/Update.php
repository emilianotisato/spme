<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Update extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'description',
        'due_date',
    ];

    /**
     * Set the accessors I need to return in JSON collections
     * @var array
     */
    protected $appends = ['userName'];

    /**
     * Get the task this update belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user this update belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Getter for the user name who create the update
     * @return mixed
     */
    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
    }
}
