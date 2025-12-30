<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        $user = auth()->user()->id;
        $cartItem = CartItem::where('user_id', $user)->with('product')->get();
        return Inertia::render('User/Cart/Index', ['cartItems' => $cartItem]);
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

    public function changeQuantity(Request $request)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Cart Item Deleted Successfully!');
    }
}
