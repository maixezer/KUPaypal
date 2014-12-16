@extends('layout.default')
@section('content')
	<?php
		$user = Auth::user();
		$wallet = Wallet::where('owner_id','=',$user->id)->first();
	?>
	<section id="welcome" class="color-dark bg-white">
			<div class="container ">
			    <div class="row">
			    	<div class="col-lg-8 col-md-8">
			    		<div class="panel-body">
				                <div id="performance1" style="height: 5px;"></div>
				        </div>
			    		<h3>Welcome, {{ $user->first_name.' '.$user->last_name }}</h3>
			    		<!-- <p>Account Type: Premier Status: Unverified Get VerifiedSending and Withdrawal Limits: View Limits </p> -->
			    	</div>
			    </div>
			</div>
			<div class="container ">
			    <div class="row">
			        <div class="col-lg-8 col-md-8">
			            <div class="panel panel-default">
			                <div class="panel-heading">
			                    <h3>KUPayPal balance: {{ number_format($wallet->balance,2) }} THB</h3>
			                    {{ Form::open( array('route' => 'wallets.deposit' , 'method' => 'put') ) }}
			                    <span>
			                    	Money : 
			                    	<input type="text" name="amount" class="form-control"></br>
			                    	<input type="submit" name="submit" value="Add Money" wallet-id="{{$wallet->id}}" class="btn btn-warning">
			                    <span>
			                    {{ Form::token() }}
			                    {{ Form::close() }}
				            </div>
				            <div class="panel-body">
				            	<table  align="left" border="1" cellpadding="0" cellspacing="10" id="balanceDetails" class="table table-hover" >
				            		<thead>
				            			<tr><th class="textleft">Currency</th><th class="textright">Total</th></tr>
				           		   </thead>
				            		<tbody>
				            			<tr>
				            				<td scope="row">THB&nbsp;(Primary)</td>
				            				<td class="textright"> {{ number_format($wallet->balance,2) }} THB </td>
				            			</tr>
									</tbody>
								</table>
								<button onclick="location.href='{{ URL::route('users.edit') }}'" class="btn btn-primary" style="float:left"> Edit Profile </button>
								&nbsp;&nbsp;
								<button onclick="location.href='{{ URL::route('payment.list') }}'" class="btn btn-primary" > Show payment </button>
								<button onclick="location.href='{{ URL::route('user-sign-out') }}'" class="btn btn-primary" style="float:right"> Sign Out </button>
				            </div>
				        </div>
			        </div>
			    </div>
	
			</div>
		</section>
@endsection