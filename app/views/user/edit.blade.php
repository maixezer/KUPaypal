@extends('layout.default')
@section('content')
		<?php
	        $user = Auth::user();
		    $result = explode('-' , $user->date_of_birth);
		?>

<div class="modal-dialog" style="margin-top: 150px;" >
     <div class="modal-content">

         <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="">&times;</button>
	          <h4 class="modal-title">KUPayPal Profile: {{ $user->first_name.' '.$user->last_name }}</h4>
        </div>
        <div class="modal-body">
			{{ Form::open(array('route' => array('users.update') , 'method' => 'put')) }}
	        
		    	  <span > Email</span>
		          <input type="email" class="form-control" placeholder="example@example.com" name="email" value="{{ $user->email }}" disabled/>
				  </br>

				  <span > First Name</span>
		          <input type="text" class="form-control" name="first_name" value="{{ $user->first_name}}"/>
		          @if($errors->has('first_name'))
						<p class="imt">{{ $errors->first('first_name') }}</p>
				  @endif 
		          </br>

		          <span > Last Name</span>
		          <input type="text" class="form-control" name="last_name" value="{{ $user->last_name}}"/> 
		          @if($errors->has('last_name'))
						<p class="imt">{{ $errors->first('last_name') }}</p>
				  @endif
		          </br>

		          <span> Date of Birth </span>
		          {{ Form::selectRange( 'day' , 1 , 31 , $result[2] , array(
		                  'class' => 'btn btn-default dropdown-toggle'
		                   )) }}
		          {{ Form::selectMonth( 'month' , $result[1] , array(
		                  'class' => 'btn btn-default dropdown-toggle'
		                   )) }}
		          {{ Form::selectRange( 'year' , 2015 , 1950 , $result[0] , array(
		                  'class' => 'btn btn-default dropdown-toggle'
		                   )) }}
		          </br></br>

		          <span > Address</span>
		          </br>
		          {{ Form::textarea('address' , $user->address , array (
		          			'rows' => 4,
		          			'cols' => 55
		             )) }}

		          @if($errors->has('address'))
						<p class="imt">{{ $errors->first('address') }}</p>
				  @endif
		          </br></br>

		          <span> Phone Number </span> <input type="text" class="form-control" name="phone" value="{{ $user->phone }}"/> 
		          @if($errors->has('phone'))
						<p class="imt">{{ $errors->first('phone') }}</p>
				  @endif
		          </br></br>

		          <span>Callback URL </span>
		          <input type="text" class="form-control" name="urlcallback" value="{{ $user->urlcallback }}"/> 
		          <br>
				  {{ Form::submit('Update Profile',array('class' => 'btn btn-success'))}}
				  <span style="float:right;"><a href="{{URL::route('users.profile')}}"> Back </a></span>
	       
	        	{{ Form::token() }}
	     		{{ Form::close() }}
		</div>
	</div>
</div>

	<style type="text/css">
    	.imt {
    		color: red;
    	}
    </style>
@endsection