<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskLogAction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'action',
        'slug',
    ];

    public function taskLogs(): HasMany
    {
        return $this->hasMany(TaskLog::class);
    }
}
