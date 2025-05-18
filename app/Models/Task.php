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
        'status',
        'user_id',
        'uuid',
    ];
    protected $appends = ['attachment_url'];
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
            if (empty($task->status)) {
                $task->status = 'pending';
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
