@extends('layouts.master')

@section('content')
<div>
    <a href="{{ route('login') }}">login</a>
</div>

<div>
    <a href="{{ route('register') }}">register</a>
</div>
@endsection
