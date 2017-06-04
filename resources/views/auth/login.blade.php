@extends('layouts.master')

@section('header')
    <h1>Login</h1>
@endsection

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div>
        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('username'))
            {{ $errors->first('username') }}
        @endif
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
            {{ $errors->first('password') }}
        @endif

    </div>

    <div>
        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>
    </div>

    <div>
        <button type="submit">Login</button>
    </div>

    <div>
        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
    </div>
</form>
@endsection
