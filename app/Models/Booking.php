<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'lapangan_id',
        'nama_pemesan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status',
        'metode_pembayaran',
        'bukti_pembayaran',
        'catatan_pembayaran',
        'user_id',
        'kode_booking',
        'checked_in_at',
        'payment_deadline',
'payment_verified_at',
'payment_reference',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'checked_in_at' => 'datetime',
        'payment_deadline' => 'datetime',
'payment_verified_at' => 'datetime',
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}