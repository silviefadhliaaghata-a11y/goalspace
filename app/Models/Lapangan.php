<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'harga',
        'gambar',
        'deskripsi',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}