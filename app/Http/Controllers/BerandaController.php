<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    //

    public function index()
    {
        $products = Product::all();
        return view('pelanggan.index', compact('products'));
    }
}
