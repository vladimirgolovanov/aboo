@extends('layouts.master')

@section('header')
    <h1>Reset Password</h1>
@endsection

@section('content')
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif

    <form role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div>
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>

        <div>
            <button type="submit">Send Password Reset Link</button>
        </div>
    </form>
@endsection
