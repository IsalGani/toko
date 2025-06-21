<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    //
public function index()
    {
        $pelanggans = User::where('level', 0)->get();
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 0,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan ditambahkan');
    }

    public function edit($id)
    {
        $pelanggan = User::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$pelanggan->id,
        ]);

        $pelanggan->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan diperbarui');
    }

    public function destroy($id)
    {
        User::where('id', $id)->where('level', 0)->delete();
        return back()->with('success', 'Pelanggan dihapus');
    }
}
