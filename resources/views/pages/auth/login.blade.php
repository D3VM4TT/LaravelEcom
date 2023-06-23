@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <main class="homepage">
        <section class="login-page">
            <div class="login-form-box">
                <div class="login-title">Login</div>
                <div class="login-form">
                    <form action="{{route('login')}}" method="post">
                        @csrf
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="john@gmail.com" class="@if ($errors->has('email')) has-error @endif">
                            @if ($errors->has('email'))
                                <span class="field-error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="field">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="******" class="@if ($errors->has('password')) has-error @endif">
                            @if ($errors->has('password'))
                                <span class="field-error">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="field">
                            <button type="submit" class="btn btn-primary btn-block">
                                Login
                            </button>
                        </div>
                    </form>
                    <div>
                        Dont have a account yet? <a href="{{route('register')}}">Register</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
