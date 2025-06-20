<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StokController extends Controller
{
    //
    public function index(Request $request)
    {
        $products = Product::with('category');

        if ($request->filled('search')) {
            $products->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $products->where('category_id', $request->category_id); // nama kolom tetap 'category_id'
        }

        $products = $products->get();
        $categories = Category::all(); // ✅ ganti dari $categorys

        return view('stok.index', compact('products', 'categories'));
    }
}
