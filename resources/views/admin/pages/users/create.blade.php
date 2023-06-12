@extends('layouts.admin')

@section('title', 'Admin Users')
@section('content_title', 'User Management: Create User')

@section('content')
    <div class="w-full">
        <form id="createUserForm" name="createUserForm" method="post" action="{{ route('admin.users.store') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Username
                </label>
                <input
                    class="shadow appearance-none border rounded w-full @if ($errors->has('username')) border-red-500 @endif py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" placeholder="Username" name="name">
                @if ($errors->has('username'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    class="shadow appearance-none border @if ($errors->has('email')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="email" placeholder="johan@email.com" name="email">
                @if ($errors->has('email'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    class="shadow appearance-none border  @if ($errors->has('password')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" placeholder="******************" name="password">
                @if ($errors->has('password'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm-password">
                    Confirm Password
                </label>
                <input
                    class="shadow appearance-none border  @if ($errors->has('confirm-password')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="confirm-password" type="password" placeholder="******************" name="confirm-password">
                @if ($errors->has('confirm-password'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('confirm-password') }}</p>
                @endif
            </div>

            <div class="mb-6">
                <label for="roles" class="block text-gray-700 text-sm font-bold mb-2">Select User Roles</label>
                <select multiple id="roles" name="roles"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option disabled selected>Choose Roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
                @if ($errors->has('roles'))
                    <p class="text-red-500 text-xs italic">{{ $errors->first('roles') }}</p>
                @endif
            </div>
            <div class="flex justify-end">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create User
                </button>
            </div>
        </form>

    </div>

@endsection
