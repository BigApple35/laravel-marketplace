<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot(){
        parent::boot();

        static::creating(function ($order) {    $prefix = 'ORD-';
            $date = now()->format('Ymd');    $randomString = strtoupper(Str::random(5)); // Adjust length as needed
            $order->kode_pesanan = $prefix . $date . '-' . $randomString;
        });
        
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
