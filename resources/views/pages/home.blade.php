@extends('layouts.master')
@section('title', 'Home')

@section('content')
    @include('pages.components.home.header')
    <div class="container mx-auto mt-7">
        <x-featured-products :products="$featured_products">
            <x-slot name="title">
                Featured Products
            </x-slot>
        </x-featured-products>
    </div>
@endsection
