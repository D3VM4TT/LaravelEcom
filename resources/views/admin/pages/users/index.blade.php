@extends('layouts.admin')

@section('title', 'Admin Users')
@section('content_title', 'User Management')

@section('content')
    <div class='overflow-x-auto w-full'>

        <div class="my-3 float-right" >
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                href="{{ route('users.create') }}"> Create New User</a>
        </div>

        @if ($message = Session::get('success'))
            {{-- TODO: Make this a snippet --}}
            <div class="alert alert-success">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $message }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            </div>
        @endif

        <table
            class='mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
            <thead class="bg-gray-900">
                <tr class="text-white text-left">
                    <th class="font-semibold text-sm uppercase px-6 py-4"> No </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Name </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Roles </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Action </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
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
                            <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endsection
