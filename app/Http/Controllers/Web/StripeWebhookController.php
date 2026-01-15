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
                $order_id = $session->metadata->order_id;
                $grand_total = $session->metadata->grand_total;

                Payment::firstOrCreate(
                    ['stripe_payment_intent_id' => $session->payment_intent],
                    [
                        'order_id' => $order_id,
                        'amount_paid' => $grand_total,
                        'status' => 'succeeded'
                    ]
                );


                $order = Order::find($order_id);
                if ($order->status !== 'paid') {
                    $order->update(['status' => 'paid']);
                }
                $cartItemIds = OrderItem::where('order_id', $order_id)->pluck('product_id');
                CartItem::where('user_id', $userId)
                    ->whereIn('product_id', $cartItemIds)
                    ->where('is_selected', 1)
                    ->delete();
            } catch (\Exception $e) {
                \Log::error('Stripe webhook processing failed: ' . $e->getMessage());
                return response('Webhook processing error', 500);
            }
        }


        return response('Webhook handled', 200);
    }
}
