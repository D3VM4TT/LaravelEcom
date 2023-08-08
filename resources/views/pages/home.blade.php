@extends('layouts.master')
@section('title', 'Home')

@section('content')
    @include('pages.components.home.header')

    <x-featured-products :products="$featured_products">
        <x-slot name="title">
            Featured Products
        </x-slot>
    </x-featured-products>

@endsection
