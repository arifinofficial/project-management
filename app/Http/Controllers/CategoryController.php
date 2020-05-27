<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|unique:categories',
            'description' => 'string|nullable'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description,
        ]);

        session()->flash('success', 'Data sukses ditambah.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|unique:categories,name,' . $id,
            'description' => 'string|nullable'
        ]);

        $category = Category::findOrFail($id);

        $category->update($request->all());

        session()->flash('success', 'Data sukses diubah.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if (!$category->delete()) {
            session()->flash('error', 'Error!.');
        } else {
            session()->flash('success', 'Data sukses dihapus.');
        }
    }

    public function dataTable()
    {
        $categories = Category::query();

        return DataTables::of($categories)
        ->addColumn('action', function ($categories) {
            return view('layouts.partials._action', [
                'model' => $categories,
                'edit_url' => route('category.edit', $categories->id),
                'delete_url' => route('category.destroy', $categories->id)
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
