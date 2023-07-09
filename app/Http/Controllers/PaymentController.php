<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Address;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function __construct(private CartService $cartService)
    {
    }

    public function processPayment(PaymentRequest $request)
    {
        $user = Auth::user();
        $cart = $this->cartService->getCart();

        if (!$cart || empty($cart->getItems())) {
            return redirect()->route('home');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // TODO: All payments are currently being saved as Jenny Rosen in stripe
            $payment_intent = \Stripe\PaymentIntent::create([
                'amount' => $cart->getTotal(),
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Error code will be authentication_required if authentication is needed
            echo 'Error code is:' . $e->getError()->code;
            $payment_intent_id = $e->getError()->payment_intent->id;
            $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }


        $billing_address = Address::create([
            'street' => $request->billing_address,
            'city' => 'na', // TODO: Implement this
            'state' => $request->billing_state,
            'country' => 'na', // TODO: Implement this
            'postal_code' => $request->billing_zip,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'total' => $cart->getTotal(),
            'status' => Order::STATUS_PAID,
            'payment_intent_id' => $payment_intent->id,
            'billing_email' => $request->email,
            'billing_name' => $request->card_holder,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->card_holder,
            'billing_address_id' => $billing_address->id,
        ]);

        // TODO: $cart->getItems() should return a eloquent collection
        // $order->items()->attach($cart->getItems());

        foreach ($cart->getItems() as $item) {
            $order->items()->attach($item->id);
        }

        $this->cartService->clearCart();

        return redirect()->route('order.show', ['order' => $order])->with('success', 'Payment successful!');


    }

}
