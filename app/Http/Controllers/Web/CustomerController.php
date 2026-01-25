<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('is_active', 1)->get();
        $categories = Category::where('is_featured', 1)->get();
        return Inertia::render('Dashboard', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return Inertia::render('User/Show', ['product' => $product]);
    }

    public function categoryProduct(string $id)
    {
        $category = Category::findOrFail($id);
        return Inertia::render('User/CategoryItem', ['category' => $category]);
    }
}
