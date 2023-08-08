@extends('layouts.master')
@section('title', 'Wishlist')

@section('content')
    <main class="homepage">
        @include('pages.components.home.header')
        <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
            <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->

            <div class="flex justify-start item-start space-y-2 flex-col">
                <h1 class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800">
                    Order
                    Wishlist
                </h1>
                <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">
                    {{count(auth()->user()->wishlist)}} items
                </p>
            </div>
            <div
                class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
                <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
                    <div
                        class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                        <p class="text-lg md:text-xl dark:text-white font-semibold leading-6 xl:leading-5 text-gray-800">
                            Your Wishlist
                        </p>
                        @foreach(auth()->user()->wishlist as $product)
                            <div
                                class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                                <a href="{{route('product', ['id' => $product])}}">
                                    <div class="pb-4 md:pb-8 w-full md:w-40">
                                        <img class="m-2 h-24 w-28 rounded-md border object-cover object-center"
                                             src="{{asset('/img/products/' . $product->image)}}" alt="dress"/>
                                    </div>
                                </a>
                                <div
                                    class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                                    <div class="w-full flex flex-col justify-start items-start space-y-8">
                                        <a href="{{route('product', ['id' => $product])}}">
                                            <h3 class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800">{{$product->name}}</h3>
                                        </a>
                                        <div class="flex justify-start items-start flex-col space-y-2">
                                            <p class="text-sm dark:text-white leading-none text-gray-800"><span
                                                    class="dark:text-gray-400 text-gray-300">Category: </span> {{$product->category->name}}
                                            </p>
                                            @if($product->color)
                                                <p class="text-sm dark:text-white leading-none text-gray-800"><span
                                                        class="dark:text-gray-400 text-gray-300">Color: </span> {{$product->color->name}}
                                                </p>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="flex justify-between space-x-8 items-start w-full">
                                        <p class="text-base dark:text-white xl:text-lg font-semibold leading-6 text-gray-800">
                                            ${{$product->price / 100}}</p>
                                    </div>
                                </div>
                                <div class="w-6/12 flex">
                                    <form class="" action="{{route('cart.add', ['product' => $product])}}"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button
                                            class="flex ml-auto text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded"
                                            type="submit"
                                        >
                                            Add to Cart
                                        </button>
                                    </form>
                                    <a href="{{route('wishlist.remove', ['product' => $product])}}"
                                       class="flex ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">Remove
                                        from Wishlist</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
