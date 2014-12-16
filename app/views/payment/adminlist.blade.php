@extends('layout.default')
@section('content')
<?php
	$user_email = Auth::user()->email;
?>
<center>
	<table class="table table-striped" style="width:90%" align="center"> 
		<thead>
			<th>Payment ID</th>
			<th>Merchant</th>
			<th>Customer</th>
			<th>Amount</th>
			<th>Status</th>
			<th>Cancel</th>
		</thead>
		<tbody>
		@foreach($payments as $p)
			<tr>
				<td>{{$p->id}}</td>
				<td>{{$p->merchant_email}}</td>
				<td>{{$p->customer_email}}</td>
				<td>{{$p->amount}}</td>
				<td>{{$p->status}}</td>
				<td><button onclick="location.href='{{URL::route('payment.cancel',array('id'=>$p->id))}}'">Cancel</button></td>
			</tr>
		@endforeach
		</tbody>
	<table>
	<span><a href="{{URL::route('users.profile')}}">Back</a></span>
</center>


@endsection