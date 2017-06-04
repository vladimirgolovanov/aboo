@extends('layouts.master')

@section('header')
    <h1>Register</h1>
@endsection

@section('content')
<form role="form" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div>
        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('username'))
            {{ $errors->first('username') }}
        @endif
    </div>

    <div>
        <label for="email">E-Mail Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            {{ $errors->first('email') }}
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
        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required>
    </div>

    <div>
        <button type="submit">Register</button>
    </div>

</form>
@endsection
