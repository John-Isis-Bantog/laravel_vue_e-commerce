<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $secret = config('services.stripe.STRIPE_WEBHOOK_SECRET');
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            return response('Invalid', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            try {
                $session = $event->data->object;

                $userId = $session->client_reference_id;

                $cartItems = CartItem::where('user_id', $userId)
                    ->where('is_selected', 1)
                    ->with('product')
                    ->get();

                if ($cartItems->isEmpty()) {
                    \Log::info("No cart items for user $userId");
                    return response('No cart items', 200);
                }
                $grand_total =  $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
                $order =   Order::create([
                    'user_id' => $userId,
                    'grand_total' => $grand_total,
                    'status' => 'paid'
                ]);
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);
                }
                Payment::create([
                    'order_id' => $order->id,
                    'stripe_payment_intent_id' => $session->payment_intent,
                    'amount_paid' => $grand_total,
                    'status' => 'succeeded'
                ]);

                CartItem::where('user_id', $userId)->where('is_selected', 1)->delete();
            } catch (\Exception $e) {
                \Log::error('Stripe webhook processing failed: ' . $e->getMessage());
                return response('Webhook processing error', 500);
            }
        }


        return response('Webhook handled', 200);
    }
}
