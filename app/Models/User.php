<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static string $usernameColumn = 'email';

    public static function getUsernameColumn(): string
    {
        return static::$usernameColumn;
    }

    public function tasksCreated(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by_id');
    }

    public function taskLogs(): HasMany
    {
        return $this->HasMany(TaskLog::class);
    }
}
