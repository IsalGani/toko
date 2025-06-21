<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaksi.index');
    }

    public function store(Request $request)
    {
        // Logika menyimpan detail transaksi
    }

    public function data($id)
    {
        // Return detail transaksi berdasarkan id
    }

    public function loadForm($diskon, $total, $diterima)
    {
        $bayar = $total - ($total * $diskon / 100);
        $kembali = $diterima - $bayar;

        return response()->json([
            'bayar' => $bayar,
            'kembali' => $kembali
        ]);
    }
}
