<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    //
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('reports.index', compact('transactions'));
    }
}
