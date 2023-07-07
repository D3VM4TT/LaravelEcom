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


        // TODO: set secret key to ENV variable
        \Stripe\Stripe::setApiKey('sk_test_51NPjN1B7J3V6AhSUzksz65tTtygrs5MG7WVKTJxzDw3YvCm0SQ1EEPeAQrxn9iy8ueEmLl4BeBxwkaNuoI1uwmAF00l8lcyL2m');

        try {
            $payment_intent = \Stripe\PaymentIntent::create([
                'amount' => $cart->getTotal(),
                'currency' => 'usd',
                // TODO: Create a stripe customer and pass the customer id here
//                'customer' => '{{CUSTOMER_ID}}',
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
            'status' => 'paid',
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

        return redirect()->route('order.success', ['order' => $order])->with('success', 'Payment successful!');


    }

}
