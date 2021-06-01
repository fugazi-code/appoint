<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonCopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'created_by',
        'isActive',
    ];

    public static function getList($business_id)
    {
        return (new self())->newQuery()
                           ->where('isActive', 'yes')
                           ->where('created_by', $business_id)
                           ->get()
                           ->pluck('email')
                           ->toArray();
    }
}
