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
		</thead>
		<tbody>
		@foreach($payments as $p)
			<tr>
				<td>{{$p->id}}</td>
				@if($p->merchant_email == $user_email)
					<td><b><i>{{$p->merchant_email}}</i></b></td>
					<td>{{$p->customer_email}}</td>
				@else
					<td>{{$p->merchant_email}}</td>
					<td><b><i>{{$p->customer_email}}</i></b></td>
				@endif
				<td>{{$p->amount}}</td>
				@if($p->status == 'wait for merchant validation')
					<td><a href="{{URL::route('payment.getValidate',array('id'=>$p->id))}}">Validate</a></td>
				@else
					<td>{{$p->status}}</td>
				@endif
			</tr>
		@endforeach
		</tbody>
	<table>
	<span><a href="{{URL::route('users.profile')}}">Back</a></span>
</center>


@endsection