<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'field',
        'type',
        'created_by',
    ];
}
