<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     * Apply the scope all Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy('created_at', 'DESC');
    }
}
