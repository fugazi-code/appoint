<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'email',
        'status',
        'type',
    ];

    public $with = ['customer'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
