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
            'is_featured' => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return Inertia::render('Admin/Category/Edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255|unique:categories,title,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_featured' => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
        ]);

        $validatedData['is_featured'] = $request->boolean('is_featured');
        $validatedData['is_active'] = $request->boolean('is_active');
        $oldImage = $category->image; // Keep track of old URL
        if ($request->hasFile('image')) {
            $validatedData['image'] = SupabaseStorage::upload(
                $request->file('image'),
                'categories'
            );
        }

        $category->update($validatedData);

        // Delete old image only if a new image was uploaded
        if ($request->hasFile('image') && $oldImage) {
            SupabaseStorage::deleteByUrl($oldImage);
        }
        return redirect()
            ->route('category.index')
            ->with('success', 'Category updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if ($category->image != null) {
            $image = $category->image;
            SupabaseStorage::deleteByUrl($image);
        }
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category Deleted Successfully!');
    }
}
