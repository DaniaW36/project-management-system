<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'proj_name',
        'proj_desc',
        'user_id',
        'created_by',
        'proj_start_date',
        'proj_end_date',
        'proj_status',
        'proj_statusDetails',
        'proj_latest_update',
        'proj_attachments'
    ];

    protected $casts = [
        'proj_start_date' => 'datetime',
        'proj_end_date' => 'datetime',
        'proj_latest_update' => 'datetime',
        'proj_attachments' => 'array'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Assuming each project belongs to one user
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor to ensure proj_attachments is always an array
    public function getProjAttachmentsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        return is_array($value) ? $value : json_decode($value, true) ?? [];
    }

    // Mutator to ensure proj_attachments is stored as JSON
    public function setProjAttachmentsAttribute($value)
    {
        $this->attributes['proj_attachments'] = is_array($value) ? json_encode($value) : $value;
    }
}
