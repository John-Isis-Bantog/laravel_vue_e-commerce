<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedItems = CartItem::where('user_id', auth()->id())->where('is_selected', '1')->with('product')->get();
        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Please Select an Item Before Checkout!');
        }
        $totalPrice = $selectedItems->sum(fn($item) => $item->product->price * $item->quantity);
        return Inertia::render('User/Checkout/Index', ['selectedItems' => $selectedItems, 'totalPrice' => $totalPrice]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
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
    public function createSession()
    {
        $selectedItems = CartItem::where('user_id', auth()->id())->where('is_selected', '1')->with('product')->get();
        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Please Select an Item Before Checkout!');
        }

        Stripe::setApiKey(config('services.stripe.STRIPE_SECRET'));
        $lineItems = $selectedItems->map(function ($item) {
            $product = $item->product;

            $productData = [
                'name' => $product->name,
            ];

            if (!empty($product->image)) {
                $productData['images'] = [$product->image];
            }

            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => $productData,
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();


        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('products.index'),
            'cancel_url' => route('checkout.index'),
        ]);
        return redirect($session->url);
    }
}
