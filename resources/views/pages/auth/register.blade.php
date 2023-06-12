@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <main class="homepage">
        <section class="login-page">
            <div class="login-form-box">
                <div class="login-title">Register</div>
                <div class="login-form">
                    <form action="{{route('register')}}" method="post">
                        @csrf

                        <div class="field">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" class="@if ($errors->has('name'))has-error @endif">
                            @if ($errors->has('name'))
                                <span class="field-error">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
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
                            <label for="password_confirmation">Password Confirmation</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="******">
                        </div>
                        <div class="field">
                            <button type="submit" class="btn btn-primary btn-block">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
