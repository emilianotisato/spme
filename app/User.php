<?php

namespace App;

use App\Notifications\ResetPassword;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'client_id', 'config', 'receive_notifications'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The user assigned tasks
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_user');
    }

    /**
     * Tasks opened by this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function openTasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Updates leved by this user
     *
     * @return void
     */
    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    /**
     * Scope a query to only include managers, staff and freelancers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWorkForce($query)
    {
        return $query->where('client_id', '=', null);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
