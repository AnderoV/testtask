<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'user_id',
        'uuid',
    ];

    protected $casts = [
        'uuid' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Task $task) {
            if (empty($task->uuid)) {
                $task->uuid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
