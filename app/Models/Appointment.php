<?php

namespace App\Models;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->created_by = Auth::user()->id;
        });
    }

    protected $fillable = [
        'lead_id',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'customer_status',
        'status'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
