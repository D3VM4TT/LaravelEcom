@extends('layouts.admin')

@section('title', 'Admin Products')
@section('content_title', 'Product Management')

@section('content')
    <div class='overflow-x-auto w-full'>

        <div class="my-3 float-right">
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
               href="{{ route('admin.products.create') }}"> Create New Product</a>
        </div>

        <x-admin-table  :headers="['No','Name', 'Image', 'Price','Category','Action']">
            <x-slot name="tableBody">
                @foreach ($data as $key => $product)
                    <tr>
                        <td class="px-6 py-4 text-center">{{ ++$i }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p> {{ $product->name }}</p>
                                    <p class="text-gray-500 text-sm font-semibold tracking-wide"> {{ \Illuminate\Support\Str::limit($product->description, 100, $end='...') }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <img
                                src="{{ asset('/img/products/' . $product->image) }}"
                                class="h-16 w-16 object-cover"
                                alt="{{$product->name}}" />
                        </td>

                        <td class="px-6 py-4 text-center">{{$product->price}}</td>
                        <td class="px-6 py-4 text-center">{{ ($product->category) ? $product->category->name : '' }}</td>
                        <td class="px-6 py-4 text-center">
                            <a class="btn btn-info" href="{{ route('admin.products.show', $product->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('admin.products.edit', $product->id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.products.destroy', $product->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-admin-table>
    </div>

@endsection
