@extends('layouts.admin')

@section('title', 'Admin Orders')
@section('content_title', 'Order Management')

@section('content')
    <div class='overflow-x-auto w-full'>

        <x-admin-table :headers="['No','Total', 'Customer', 'Status','Date','Action']">
            <x-slot name="tableBody">
                @foreach ($orders as $key => $order)
                    <tr>
                        <td class="px-6 py-4 text-center">{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p> ${{ $order->total }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{route('admin.users.show', ['user' => $order->user])}}">
                                {{$order->user->email}}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="py-1 bg-blue-500 text-white text-sm font-medium rounded-full">
                                {{$order->status}}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">{{ $order->created_at}}</td>
                        <td class="px-6 py-4 text-center">
                            <a class="btn btn-info" href="{{ route('admin.orders.show', $order) }}">Show</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.products.destroy', $order->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-admin-table>
    </div>

@endsection
