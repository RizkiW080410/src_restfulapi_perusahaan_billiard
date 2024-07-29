<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'mysql';
    protected $table = 'bookings';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }
}
