<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'service_id',
        'appoint_id',
        'name',
        'phone',
        'email',
        'is_verified',
        'other_details',
        'ip_address',
    ];

    public function serviceHasOne()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function appointmentHasOne()
    {
        return $this->hasOne(Appointment::class, 'id', 'appoint_id');
    }

    public function leads()
    {
        return $this->hasOne(Leads::class, 'customer_id', 'id');
    }
}
