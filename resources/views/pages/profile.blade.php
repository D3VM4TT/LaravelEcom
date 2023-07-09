@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <main class="">
        @include('pages.components.home.header')
        <div class="container mx-auto p-4">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Customer Profile</h2>
                <div class="mb-4">
                    <p class="font-semibold">Name:</p>
                    <p class="text-gray-800">{{ Auth::user()->name }}</p>
                </div>
                <div class="mb-4">
                    <p class="font-semibold">Email:</p>
                    <p class="text-gray-800">{{ Auth::user()->email }}</p>
                </div>
                <h3 class="text-xl font-semibold my-4">Orders</h3>
                <table class="w-full border-collapse">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-100 text-left text-sm font-semibold uppercase tracking-wider">
                            Order ID
                        </th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-sm font-semibold uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-sm font-semibold uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-sm font-semibold uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Auth::user()->orders as $order)
                        <tr class="bg-white cursor-pointer hover:bg-gray-100"
                            onclick="window.location.href='{{route('order.show', ['order' => $order])}}'">
                            <td class="px-6 py-4 whitespace-nowrap">{{$order->id}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{$order->total}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$order->status}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$order->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="flex justify-end my-4">
                    @auth
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <div class="field">
                                <button type="submit" class="btn btn-primary">
                                    Logout
                                </button>
                            </div>
                        </form>
                    @endauth
                </div>

            </div>
        </div>
    </main>
@endsection
