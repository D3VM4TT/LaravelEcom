@extends('layouts.admin')

@section('title', 'Admin Users')
@section('content_title', 'Product Management: Create User')

@section('content')
    <div class="w-full">
        <form id="productForm" name="productForm" method="post" action="{{ route('admin.products.store') }}"
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Product Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full @if ($errors->has('name')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" placeholder="name" name="name">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Product Description
                </label>
                <label for="description"></label><input
                    class="shadow appearance-none border rounded w-full @if ($errors->has('description')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" type="text" placeholder="Description" name="description">
                @if ($errors->has('description'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('description') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                    Product Price
                </label>
                <input
                    class="shadow appearance-none border rounded w-full @if ($errors->has('username')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="price" type="number" placeholder="Price" name="price">
                @if ($errors->has('price'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('price') }}</p>
                @endif
            </div>


            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                    Image
                </label>
                <input
                    class="shadow appearance-none border rounded w-full @if ($errors->has('image')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="price" type="file" placeholder="image" name="image">
                @if ($errors->has('image'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('image') }}</p>
                @endif
            </div>


            <div class="mb-6">

                <label for="categories" class="block text-gray-700 text-sm font-bold mb-2">Select a Category</label>
                <select id="categories" name="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option disabled selected>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('category'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('category') }}</p>
                @endif
            </div>

            <div class="mb-6">
                <label for="colors" class="block text-gray-700 text-sm font-bold mb-2">Select Product Colors</label>
                <select multiple id="colors" name="colors[]"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option disabled selected>Select Colors</option>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('colors'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('colors') }}</p>
                @endif
            </div>

            <div class="flex justify-end">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create Product
                </button>
            </div>
        </form>

    </div>

@endsection
