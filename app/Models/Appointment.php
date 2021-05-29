<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'provider',
        'service',
        'date_appoint',
        'time_appoint',
        'notes',
    ];

    public function hasOneService()
    {
        return $this->hasOne(Service::class, 'id', 'service');
    }


    public function hasOneCustomer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
