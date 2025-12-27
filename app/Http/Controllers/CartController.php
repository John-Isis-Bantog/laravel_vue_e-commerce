<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        return Inertia::render('User/Cart/Index');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:5'
        ]);
        $user = auth()->user();
        $product = Product::findOrFail($validated['id']);
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $validated['quantity']
            ]);
        } else {
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity']
            ]);
        }


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
