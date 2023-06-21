@extends('layouts.admin')

@section('title', 'Admin Categories')
@section('content_title', 'Category Management')

@section('content')
    <div class='overflow-x-auto w-full'>

        <form id="categoryForm" name="categoryForm" method="post"
              action="{{ (isset($category)) ? route('admin.categories.update', ['category' => $category]) : route('admin.categories.store') }}"
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full" enctype="multipart/form-data">
            @csrf

            @if(isset($category))
                @method('patch')
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Category Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full @if ($errors->has('name')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" placeholder="name" name="name" value="{{$category->name ?? ''}}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="flex justify-end">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    {{isset($category) ? 'Update' : 'Create'}} Category
                </button>
            </div>
        </form>


        <x-admin-table :headers="['ID','Name','Products','Action']">
            <x-slot name="tableBody">
                @foreach ($categories as $key => $category)
                    <tr>
                        <td class="px-6 py-4 text-center">{{ $category->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p> {{ $category->name }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- TODO: Implememnt this --}}
                        <td class="px-6 py-4 text-center">-</td>
                        <td class="px-6 py-4 text-center">
                            <a class="btn btn-primary" href="{{ route('admin.categories.index', ['category' => $category]) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.categories.destroy', $category->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-admin-table>
    </div>

@endsection
