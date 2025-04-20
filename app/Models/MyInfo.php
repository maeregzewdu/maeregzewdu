<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyInfo extends Model
{
    /** @use HasFactory<\Database\Factories\MyInfoFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'social_links'
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
    
}
