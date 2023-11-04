<?php

namespace App\Models;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'type',
        'appointment_status',
        'postcode',
        'product_name',
        'additional_field',
        'message',
        'source'
    ];

    public function appointments()
    {
        return $this->hasOne(Appointment::class);
    }
}
