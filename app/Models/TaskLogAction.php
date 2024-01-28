<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskLogAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'slug',
    ];

    public function taskLogs(): HasMany
    {
        return $this->hasMany(TaskLog::class);
    }
}
