<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'technologies',
        'features',
        'status',
        'thumbnail',
        'gallery',
        'type',
        'client_name',
        'project_url',
        'github_url',
        'is_featured',
        'created_by',
    ];

    protected $casts = [
        'technologies' => 'array',
        'features' => 'array',
        'gallery' => 'array',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
