<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'cost',
        'time',
        'buffer',
        'private_service',
        'ordering',
        'color',
        'video_meeting',
        'created_by'
    ];
}
