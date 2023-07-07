@extends('layouts.master')
@section('title', 'Checkout')

{{-- TODO: Add error messages to form here --}}

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Set your publishable key: remember to change this to your live publishable key in production
            // See your keys here: https://dashboard.stripe.com/apikeys
            const stripe = Stripe('pk_test_51NPjN1B7J3V6AhSUQBP3xmkbaXbrUN7rCe9Mncp6UKG3J6ADVGTeOCwBtulFHa9XOtKUSeJHvMQkMQaGQrar800A00vllMsSlW');


            // ------------ RENDER STRIPE FORM ------------
            const options = {
                mode: 'payment',
                amount: 1099,
                currency: 'usd',
                paymentMethodCreation: 'manual',
                // Fully customizable with appearance API.
                appearance: {/*...*/},
            };

            // Set up Stripe.js and Elements to use in checkout form
            const elements = stripe.elements(options);

            // Create and mount the Payment Element
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');


            // ------------ HANDLE FORM SUBMISSION ------------
            const form = document.getElementById('payment-form');
            const submitBtn = document.getElementById('submit');

            const handleError = (error) => {
                const messageContainer = document.querySelector('#error-message');
                messageContainer.textContent = error.message;
                submitBtn.disabled = false;
            }

            form.addEventListener('submit', async (event) => {

                event.preventDefault();

                // Prevent multiple form submissions
                if (submitBtn.disabled) {
                    return;
                }

                // Disable form submission while loading
                submitBtn.disabled = true;

                // Trigger form validation and wallet collection
                const {error: submitError} = await elements.submit();
                if (submitError) {
                    handleError(submitError);
                    return;
                }

                // Create the PaymentMethod using the details collected by the Payment Element
                const {error, paymentMethod} = await stripe.createPaymentMethod({
                    elements,
                    params: {
                        billing_details: {
                            name: 'Jenny Rosen',
                        }
                    }
                });

                console.log('payment method created');

                if (error) {
                    // This point is only reached if there's an immediate error when
                    // creating the PaymentMethod. Show the error to your customer (for example, payment details incomplete)
                    handleError(error);
                    return;
                }


                console.log('attempting to submit form');
                console.log(form);
                document.getElementById('payment-method-id').value = paymentMethod.id;

                document.getElementById('checkout-form').submit();

            });

        });
    </script>
@endpush

@section('content')
    <div class="container mx-auto mt-10">
        <div class="flex flex-col items-center border-b bg-white py-4 sm:flex-row sm:px-10 lg:px-20 xl:px-32">
            <a href="#" class="text-2xl font-bold text-gray-800">sneekpeeks</a>
            <div class="mt-4 py-2 text-xs sm:mt-0 sm:ml-auto sm:text-base">
                <div class="relative">
                    <ul class="relative flex w-full items-center justify-between space-x-2 sm:space-x-4">
                        <li class="flex items-center space-x-3 text-left sm:space-x-4">
                            <a class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-200 text-xs font-semibold text-emerald-700"
                               href="#"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg
                                >
                            </a>
                            <span class="font-semibold text-gray-900">Shop</span>
                        </li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        <li class="flex items-center space-x-3 text-left sm:space-x-4">
                            <a class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-600 text-xs font-semibold text-white ring ring-gray-600 ring-offset-2"
                               href="#">2</a>
                            <span class="font-semibold text-gray-900">Checkout</span>
                        </li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        <li class="flex items-center space-x-3 text-left sm:space-x-4">
                            <a class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-400 text-xs font-semibold text-white"
                               href="#">3</a>
                            <span class="font-semibold text-gray-500">Order Confirmation</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="grid sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32">
            <div class="px-4 pt-8">
                <p class="text-xl font-medium">Order Summary</p>
                <p class="text-gray-400">Check your items. And select a suitable shipping method.</p>
                <div class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">
                    @foreach($cart->getItems() as $item)
                        <div class="flex flex-col rounded-lg bg-white sm:flex-row">
                            <img class="m-2 h-24 w-28 rounded-md border object-cover object-center"
                                 src="{{asset('/img/products/' . $item->product->image)}}"
                                 alt=""/>
                            <div class="flex items-center">
                                <div class="flex w-full flex-col px-4 py-4">
                                    <span class="font-semibold">{{$item->product->name}}</span>
                                    <span class="float-right text-gray-400">{{$item->product->category->name}}</span>
                                    <p class="text-lg font-bold">${{$item->total / 100}}</p>
                                    <p class="text-sm font-bold">Quantity: {{$item->quantity}}</p>
                                </div>
                            </div>


                        </div>
                    @endforeach
                </div>

                {{--                <p class="mt-8 text-lg font-medium">Shipping Methods</p>--}}
                {{--                <form class="mt-5 grid gap-6">--}}
                {{--                    <div class="relative">--}}
                {{--                        <input class="peer hidden" id="radio_1" type="radio" name="radio" checked/>--}}
                {{--                        <span--}}
                {{--                            class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>--}}
                {{--                        <label--}}
                {{--                            class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4"--}}
                {{--                            for="radio_1">--}}
                {{--                            <img class="w-14 object-contain" src="/images/naorrAeygcJzX0SyNI4Y0.png" alt=""/>--}}
                {{--                            <div class="ml-5">--}}
                {{--                                <span class="mt-2 font-semibold">Fedex Delivery</span>--}}
                {{--                                <p class="text-slate-500 text-sm leading-6">Delivery: 2-4 Days</p>--}}
                {{--                            </div>--}}
                {{--                        </label>--}}
                {{--                    </div>--}}
                {{--                    <div class="relative">--}}
                {{--                        <input class="peer hidden" id="radio_2" type="radio" name="radio" checked/>--}}
                {{--                        <span--}}
                {{--                            class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>--}}
                {{--                        <label--}}
                {{--                            class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4"--}}
                {{--                            for="radio_2">--}}
                {{--                            <img class="w-14 object-contain" src="/images/oG8xsl3xsOkwkMsrLGKM4.png" alt=""/>--}}
                {{--                            <div class="ml-5">--}}
                {{--                                <span class="mt-2 font-semibold">Fedex Delivery</span>--}}
                {{--                                <p class="text-slate-500 text-sm leading-6">Delivery: 2-4 Days</p>--}}
                {{--                            </div>--}}
                {{--                        </label>--}}
                {{--                    </div>--}}
                {{--                </form>--}}
            </div>
            <div class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0">
                <p class="text-xl font-medium">Payment Details</p>
                <p class="text-gray-400">Complete your order by providing your payment details.</p>
                <div class="">

                    <form action="{{route('order.process-payment')}}" method="post" id="checkout-form">
                        @csrf
                        <input hidden type="text" name="payment_method_id" id="payment-method-id"/>
                        <div>
                            <label for="email" class="mt-4 mb-2 block text-sm font-medium">Email</label>
                            <div class="relative">
                                <input type="text" id="email" name="email"
                                       class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="your.email@gmail.com"/>
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="mt-4 mb-2 block text-sm font-medium">Phone</label>
                            <div class="relative">
                                <input type="text" id="phone" name="phone"
                                       class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="111 111 1111"/>
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
                                    <i class="fas fa-phone h-4 w-4 text-gray-400"></i>
                                </div>
                            </div>

                        </div>
                        <div>
                            <label for="billing-address" class="mt-4 mb-2 block text-sm font-medium">Billing
                                Address</label>
                            <div class="flex flex-col sm:flex-row">
                                <div class="relative flex-shrink-0 sm:w-7/12">
                                    <input type="text" id="billing-address" name="billing_address"
                                           class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Street Address"/>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
                                        <img class="h-4 w-4 object-contain"
                                             src="https://flagpack.xyz/_nuxt/4c829b6c0131de7162790d2f897a90fd.svg"
                                             alt=""/>
                                    </div>
                                </div>
                                <select type="text" name="billing_state"
                                        class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="State">State</option>
                                </select>
                                <input type="text" name="billing_zip"
                                       class="flex-shrink-0 rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none sm:w-1/6 focus:z-10 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="ZIP"/>
                            </div>
                        </div>
                        <div>
                            <label for="card-holder" class="mt-4 mb-2 block text-sm font-medium">Card Holder</label>
                            <div class="relative">
                                <input type="text" id="card-holder" name="card_holder"
                                       class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm uppercase shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Your full name here"/>
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="payment-form">
                        <div id="payment-element">
                            <!-- Elements will create form elements here -->
                        </div>
                        <div id="error-message">
                            <!-- Display error message to your customers here -->
                        </div>
                        <!-- Total -->
                        <div class="mt-6 border-t border-b py-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">Subtotal</p>
                                <p class="font-semibold text-gray-900">${{$cart->getTotal() / 100}}</p>
                            </div>
                            {{--                            <div class="flex items-center justify-between">--}}
                            {{--                                <p class="text-sm font-medium text-gray-900">Shipping</p>--}}
                            {{--                                <p class="font-semibold text-gray-900">$8.00</p>--}}
                            {{--                            </div>--}}
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Total</p>
                            <p class="text-2xl font-semibold text-gray-900">${{$cart->getTotal() / 100}}</p>
                        </div>

                        <button type="submit"
                                class="mt-4 mb-8 w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white"
                                id="submit">
                            Place Order
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>

@endsection
