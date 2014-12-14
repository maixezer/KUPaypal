@extends('layout.default')
@section('content')

<center>
	<h1> KUPAYPAL </h1>
	@if(Auth::check())
		<span style="cursor:pointer;" class="text-info"><a href="{{ URL::route('user-sign-out')}}">Sign Out</a></span>
	@else
		<span style="cursor:pointer;" class="text-info"><a href="{{ URL::route('user-sign-in')}}">Sign In</a></span>
	@endif
</center>

@endsection