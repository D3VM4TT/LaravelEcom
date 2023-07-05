<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct(private CartService $cartService)
    {
    }

    public function processPayment(PaymentRequest $request)
    {

        $cart = $this->cartService->getCart();

        if (!$cart || empty($cart->getItems())) {
            return redirect()->route('home');
        }



        // TODO: Create a new Order for the customer


        // TODO: set secret key to ENV variable
        \Stripe\Stripe::setApiKey('sk_test_51NPjN1B7J3V6AhSUzksz65tTtygrs5MG7WVKTJxzDw3YvCm0SQ1EEPeAQrxn9iy8ueEmLl4BeBxwkaNuoI1uwmAF00l8lcyL2m');

        try {
            \Stripe\PaymentIntent::create([
                'amount' => 1099,
                'currency' => 'usd',
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

        return redirect()->route('order.success', ['id' => 1])->with('success', 'Payment successful!');


    }

}
