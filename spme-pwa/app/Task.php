<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'severity_id',
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
    protected $with = ['project', 'contacts', 'updates', 'user', 'assigned', 'taskStatus', 'taskSeverity'];

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
     * The task severity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskSeverity()
    {
        return $this->belongsTo(Severity::class);
    }

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

        // Get only non closed tasks on normal queries
        static::addGlobalScope('closed', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC')
                ->where('closed', null);
        });
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
        return $this->project->building->name . ' (' . $this->project->name . ')';
    }
}