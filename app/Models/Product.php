<?php

namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'price',
        'description', // hanya jika kolom ini memang ada di DB
        'discount',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'product_id'); // sebaiknya pakai nama 'product_id' bukan 'id_produk'
    }
}
