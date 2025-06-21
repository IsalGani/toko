<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $fillable = ['user_id', 'total_harga', 'bayar', 'tanggal']; // sesuaikan dengan kolom di migrasi


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }
}
