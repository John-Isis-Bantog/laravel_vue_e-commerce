<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\SupabaseStorage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Admin/Category/Index', ['category' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'unique:categories,title|max:255|required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validatedData['is_featured'] = $request->boolean('is_featured');
        $validatedData['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $validatedData['image'] = SupabaseStorage::upload($request->file('image'), 'categories');
        }
        Category::create($validatedData);
        return redirect()->route('category.index')->with('success', 'Category Has Been Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
