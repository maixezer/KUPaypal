@extends('layout.default')
@section('content')

<center>
	<h1> KUPAYPAL </h1>
	@if(Auth::check())
		<button onclick="location.href='{{URL::Route('users.profile')}}'" class="btn btn-warning" >USER PROFILE</button>
		<span style="cursor:pointer;" class="text-info"><a href="{{ URL::route('user-sign-out')}}">Sign Out</a></span>
	@else
		<span style="cursor:pointer;" class="text-info"><a href="{{ URL::route('user-sign-in')}}">Sign In</a></span>
	@endif
</center>

@endsection