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
        'hide_client',
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
    protected $with = ['project', 'updates', 'user', 'assigned', 'status', 'priority'];

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
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * The task priority
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    /**
     * The updates for this task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('closed', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
    }

    /**
     * Scope a query to only include non closed task
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpened($query)
    {
        return $query->where('closed', null);
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
