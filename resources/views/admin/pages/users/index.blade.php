@extends('layouts.admin')

@section('title', 'Admin Users')
@section('content_title', 'User Management')

@section('content')
    <div class='overflow-x-auto w-full'>

        <div class="my-3 float-right">
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
               href="{{ route('admin.users.create') }}"> Create New User</a>
        </div>

        <x-admin-table :headers="['No','Name','Roles','Action']">
            <x-slot name="tableBody">
                @foreach ($data as $key => $user)
                    <tr>
                        <td class="px-6 py-4 text-center">{{ ++$i }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p> {{ $user->name }}</p>
                                    <p class="text-gray-500 text-sm font-semibold tracking-wide"> {{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $roleName)
                                    {{ $roleName }},
                                @endforeach
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a class="btn btn-info" href="{{ route('admin.users.show', $user->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.users.destroy', $user->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-admin-table>
    </div>

@endsection
