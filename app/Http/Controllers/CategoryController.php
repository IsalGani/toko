<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = \App\Models\Category::orderBy('id', 'desc')->get();
        return view('category.index', compact('categories'));
    }



    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        Category::create([
            'nama_category' => $request->nama_category
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }



    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        $category->update([
            'nama_category' => $request->nama_category
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }

    public function data()
    {
        $category = Category::orderBy('id', 'desc')->get();

        return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('aksi', function ($category) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('category.update', $category->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-edit"></i></button>
                    <button onclick="deleteData(`' . route('category.destroy', $category->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
