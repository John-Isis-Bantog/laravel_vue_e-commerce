<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PHPUnit\Metadata\Metadata;
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
        $hasUnavailableItem = $selectedItems->contains(fn($item) => !$item->product->is_active);
        if ($hasUnavailableItem) {
            return redirect()->route('cart.index')->with('error', 'Please Remove an Unavailable Item in Your Checkout');
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
        $user_id = auth()->user()->id;
        \Log::info('User ID from session: ' . $user_id);
        Stripe::setApiKey(config('services.stripe.STRIPE_SECRET'));
        $lineItems = $selectedItems->map(function ($item) {
            $product = $item->product;
            $productData = [
                'name' => $product->name,
            ];

            if (!empty($product->image)) {
                $productData['images'] = [$product->image];
            };

            return [
                'price_data' => [
                    'currency' => 'php',
                    'product_data' => $productData,
                    'unit_amount' => (int) ($product->price * 100),

                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        $cartItems = CartItem::where('user_id', $user_id)
            ->where('is_selected', 1)
            ->with('product')
            ->get();
        $grand_total =  $cartItems->sum(fn($i) => $i->product->price * $i->quantity);

        $order =   Order::create([
            'user_id' => $user_id,
            'grand_total' => $grand_total,
            'status' => 'pending'
        ]);
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'client_reference_id' => $user_id,
            'success_url' => route('products.index', ['success' => 'true']),
            'cancel_url' => route('checkout.index', ['error' => true]),
            'metadata' => [
                'order_id' => $order->id,
                'grand_total' => $grand_total,
            ],
        ]);
        return redirect($session->url);
    }
}
