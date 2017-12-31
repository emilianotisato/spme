<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'assigned_user',
        'project_id',
        'priority_id',
        'status_id',
        'client_visibility',
        'subject',
        'description',
        'closed',
    ];

    /**
     * Set the accessors I need to return in JSON collections
     * @var array
     */
    protected $appends = ['projectFullName'];

    /**
     * The relations to eager load on every query.
     * @var array
     */
    protected $with = ['project', 'updates', 'user', 'assigned', 'taskStatus', 'taskPriority'];

    /**
     * The user who creat the task
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The user assigned to this task
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_user');
    }

    /**
     * The Project this task belogns to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The task status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskStatus()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * The task priority
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskPriority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function updates()
    {
        return $this->hasMany(Update::class);
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
        $builder->orderBy('created_at', 'DESC')
                ->where('closed', null);
    }

    /**
     * Helper for closing the task as a timestamp
     */
    public function closeTask()
    {
        $this->closed = Carbon::now()->toDateTimeString();
        $this->save();
    }

    /**
     * Accesor for de full name of the Project associated
     * @return string
     */
    public function getProjectFullNameAttribute()
    {
        return $this->project->client->name . ' (' . $this->project->name . ')';
    }
}
