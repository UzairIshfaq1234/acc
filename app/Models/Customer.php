<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->created_by = Auth::user()->id;
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id','id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class,'customer_id','id');
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class,'customer_id','id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class , 'lead_id' , 'lead_id');
    }
}
