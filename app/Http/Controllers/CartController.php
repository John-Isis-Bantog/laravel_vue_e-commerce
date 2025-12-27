<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:5'
        ]);
        $product = Product::findOrFail($validated['id']);

        auth()->user()->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => $validated['quantity']
        ]);


        return back()->with('success', 'Added to Cart');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
