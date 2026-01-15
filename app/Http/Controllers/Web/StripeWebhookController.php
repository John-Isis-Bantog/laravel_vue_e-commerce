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
                $order_id = $session->order_id;
                $grand_total = $session->grand_total;

                Payment::create([
                    'order_id' => $order_id,
                    'stripe_payment_intent_id' => $session->payment_intent,
                    'amount_paid' => $grand_total,
                    'status' => 'succeeded'
                ]);
            } catch (\Exception $e) {
                \Log::error('Stripe webhook processing failed: ' . $e->getMessage());
                return response('Webhook processing error', 500);
            }
        }


        return response('Webhook handled', 200);
    }
}
