@extends('layout.default')
@section('content')
	<?php
		$user = Auth::user();
		$payment = Payment::find($id);
	?>
	<div class="modal-dialog" style="margin-top: 150px;" >
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="">&times;</button>
          <h4 class="modal-title">KUPayPal PaymentID: {{ $payment->id }} , OrderID {{$payment->order_id}}</h4>
        </div>

		{{ Form::open(array('route'=> array('payment.putAccept',$id) , 'method' => 'put'))}}
		<div class="modal-body">
			<p> ID : {{ $payment->id }}</p>
			<p> OrderID : {{ $payment->order_id }}</p>
			<p> Status : {{ $payment->status }}</p>
			<p> Time : {{ $payment->time }}</p>
			<p> Merchant_Email : {{ $payment->merchant_email }}</p>
			<p> Amount : {{ $payment->amount }}</p>
			<div class="modal-footer">
				@if($payment->status == 'wait for customer acceptance')
					{{ Form::submit('Accept',array('class' => 'btn btn-success' , 'style' => 'float:right;'))}}
				@endif
			</div>
			{{ Form::token() }}
			{{ Form::close() }}
	    </div>
	</div>

@endsection