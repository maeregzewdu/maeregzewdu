<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'plan',
        'status',
        'source',
        'note',
        'ip_address',
        'city',
        'region',
        'country',
        'country_code',
        'timezone',
        'latitude',
        'longitude'
    ];
}
