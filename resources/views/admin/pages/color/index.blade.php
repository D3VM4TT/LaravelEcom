@extends('layouts.admin')

@section('title', 'Admin Colors')
@section('content_title', 'Color Management')

@section('content')
    <div class='overflow-x-auto w-full'>

        <form id="colorForm" name="colorForm" method="post"
              action="{{ (isset($color)) ? route('admin.colors.update', ['color' => $color]) : route('admin.colors.store') }}"
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full" enctype="multipart/form-data">
            @csrf

            @if(isset($color))
                @method('patch')
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Color Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full @if ($errors->has('name')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" placeholder="name" name="name" value="{{$color->name ?? old('name')}}">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('name') }}</p>
                @endif
            </div>


            <div class="flex items-center">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="code">
                        Color Code
                    </label>
                    <input
                        class="shadow appearance-none border rounded  @if ($errors->has('code')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="code" type="color" placeholder="code" name="code" value="{{$color->code ?? old('code')}}">
                    @if ($errors->has('code'))
                        <p class="text-red-500 text-xs italic">{{ $errors->first('code') }}</p>
                    @endif
                </div>
                @if($color)
                    <div class="w-12 h-12 bg-red-400 rounded-full" style="background-color: {{$color->code}}"></div>
                @endif
            </div>


            <div class="flex justify-end">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    {{isset($color) ? 'Update' : 'Create'}} Color
                </button>
            </div>
        </form>


        <x-admin-table :headers="['ID','Name', 'Code', 'Products', 'Created', 'Action']">
            <x-slot name="tableBody">
                @foreach ($colors as $key => $color)
                    <tr>
                        <td class="px-6 py-4 text-center">{{ $color->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p> {{ $color->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center flex items-center">
                            <div class="mr-3">{{$color->code}}</div>
                            <div class="w-12 h-12 bg-red-400 rounded-full"
                                 style="background-color: {{$color->code}}"></div>
                        </td>
                        <td class="px-6 py-4 text-center">{{count($color->products)}}</td>
                        <td class="px-6 py-4 text-center">{{$color->created_at->format('d-m-Y')}}</td>
                        <td class="px-6 py-4 text-center">
                            <a class="btn btn-primary" href="{{ route('admin.colors.index', ['color' => $color]) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.colors.destroy', $color->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-admin-table>
    </div>

@endsection
