<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'level' => 'required|in:0,1,2',
        ]);

        $data['password'] = Hash::make($data['password']);

        \App\Models\User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }



    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'level' => 'required|in:0,1,2',
        ]);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }


    public function pelangganIndex()
    {
        $users = User::where('level', 0)->get(); // hanya pelanggan
        return view('pelanggan.index', compact('users'));
    }

    public function pelangganCreate()
    {
        return view('pelanggan.create');
    }

    public function pelangganStore(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 0, // pelanggan
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function pelangganEdit($id)
    {
        $user = User::where('level', 0)->findOrFail($id);
        return view('pelanggan.edit', compact('user'));
    }

    public function pelangganUpdate(Request $request, $id)
    {
        $user = User::where('level', 0)->findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // atau cek jika diisi
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function pelangganDestroy($id)
    {
        $user = User::where('level', 0)->findOrFail($id);
        $user->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
