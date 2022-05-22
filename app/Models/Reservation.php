<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'service',
        'date_appoint',
        'slots'
    ];

    protected $with = ['serviced'];

    public function serviced()
    {
        return $this->hasOne(Service::class, 'id', 'service');
    }
}
