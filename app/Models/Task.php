<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'task_desc',
        'project_id',
        'user_id',
        'task_status',
        'task_priority',
        'due_date',
        'task_attachments'
    ];

    protected $casts = [
        'due_date' => 'date',
        'task_attachments' => 'array',
        'completed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor to ensure task_attachments is always an array
    public function getTaskAttachmentsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        return is_array($value) ? $value : json_decode($value, true) ?? [];
    }

    // Mutator to ensure task_attachments is stored as JSON
    public function setTaskAttachmentsAttribute($value)
    {
        $this->attributes['task_attachments'] = is_array($value) ? json_encode($value) : $value;
    }
}
