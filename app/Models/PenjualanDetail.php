<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_details'; // gunakan plural dan sesuai migrasi

    protected $fillable = [
        'penjualan_id',
        'product_id',
        'jumlah',
        'harga',
        'subtotal',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
