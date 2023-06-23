@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <main class="homepage">
        @include('pages.components.home.header')
        Profile Page

        @auth
            {{--   Temp LOGOUT button     --}}
            <form action="{{route('logout')}}" method="post">
            @csrf
                <div class="field">
                    <button type="submit" class="btn btn-primary">
                        Logout
                    </button>
                </div>
            </form>
        @endauth
    </main>
@endsection
