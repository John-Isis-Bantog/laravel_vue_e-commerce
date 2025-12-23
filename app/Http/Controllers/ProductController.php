<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SupabaseStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Admin/Products/Index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:0',
            'is_active' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validateData['is_active'] = $request->boolean('is_active');
        if ($validateData['image'] !== null) {
            $validateData['image'] = SupabaseStorage::upload($validateData['image'], 'product');
        }

        Product::create($validateData);
        return redirect()->route('product.index')->with('success', 'product has been inserted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return Inertia::render('Admin/Products/Edit', ['product' => $product]);
    }


    public function update(Request $request, Product $product)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        Log::info('Update payload', $request->all());
        dd($validateData);
        return redirect()->route('product.index')->with('success', 'Product Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image != null) {
            $image = $product->image;
            SupabaseStorage::deleteByUrl($image);
        }

        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully!');
    }
}
