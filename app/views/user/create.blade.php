@extends('layout.default')
@section('content')
	
	<div class="modal-dialog" style="margin-top: 150px;" >
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="">&times;</button>
          <h4 class="modal-title">KUPayPal Sign In</h4>
        </div>

        {{ Form::open( array('route' => 'user-sign-up-post' , 'method' => 'post') )}}
        	<div class="modal-body">
	          <span class="imt">*</span><span > Email</span>
	          <input type="email" class="form-control" placeholder="example@example.com" name="email" {{ (Input::old('email')) ? ' value="' . e(Input::old('email')) . '"' : '' }} autofocus/>
	          @if($errors->has('email'))
					<p class="imt">{{ $errors->first('email') }}</p>
			  @endif
	          </br>

	          <span class="imt">*</span><span > Password</span>
	          <input type="password" class="form-control" name="password">
	          @if($errors->has('password'))
					<p class="imt">{{ $errors->first('password') }}</p>
			  @endif
	          </br>

	          <span class="imt">*</span><span > Password Confirmation</span>
	          <input type="password" class="form-control" name="password_confirmation">
	          @if($errors->has('password_confirmation'))
					<p class="imt">{{ $errors->first('password_confirmation') }}</p>
			  @endif

			  </br>
			  <span class="imt">*</span><span > First Name</span>
	          <input type="text" class="form-control" name="first_name" {{ (Input::old('first_name')) ? ' value="' . e(Input::old('first_name')) . '"' : '' }}/>
	          @if($errors->has('first_name'))
					<p class="imt">{{ $errors->first('first_name') }}</p>
			  @endif 
	          </br>

	          <span class="imt">*</span><span > Last Name</span>
	          <input type="text" class="form-control" name="last_name" {{ (Input::old('last_name')) ? ' value="' . e(Input::old('last_name')) . '"' : '' }}/> 
	          @if($errors->has('last_name'))
					<p class="imt">{{ $errors->first('last_name') }}</p>
			  @endif
	          </br>
	    

	          <span> Date of Birth </span>
	          {{ Form::selectRange( 'day' , 1 , 31 , 1 , array(
	                  'class' => 'btn btn-default dropdown-toggle'
	                   )) }}
	          {{ Form::selectMonth( 'month' , null , array(
	                  'class' => 'btn btn-default dropdown-toggle'
	                   )) }}
	          {{ Form::selectRange( 'year' , 2015 , 1950 , 2015 , array(
	                  'class' => 'btn btn-default dropdown-toggle'
	                   )) }}
	          </br></br>

	          <span class="imt">*</span><span > Address</span>
	          </br>
	          {{ Form::textarea('address' , null , array (
	          			'rows' => 4,
	          			'cols' => 55
	             )) }}

	          @if($errors->has('address'))
					<p class="imt">{{ $errors->first('address') }}</p>
			  @endif
	          </br>

	          <span class="imt">*</span><span> Phone Number </span> <input type="text" class="form-control" name="phone" {{ (Input::old('phone')) ? ' value="' . e(Input::old('phone')) . '"' : '' }}/> 
	          @if($errors->has('phone'))
					<p class="imt">{{ $errors->first('phone') }}</p>
			  @endif
			  <span>Callback URL </span>
		          <input type="text" class="form-control" name="urlcallback" {{ (Input::old('urlcallback')) ? ' value="' . e(Input::old('urlcallback')) . '"' : '' }}/> 
		      <br>
			</div>
          	<div class="modal-footer">
	       		{{ Form::submit('Submit',array('class' => 'btn btn-success' , 'style' => 'float:left;'))}}
	       		<span style="cursor:pointer;" class="text-info"><a href="{{ URL::route('user-sign-in')}}">Sign In</a></span>
	       	</div>

     	{{ Form::token() }}
     	{{ Form::close() }}
     	</div>
     </div>

    <style type="text/css">
    	.imt {
    		color: red;
    	}
    </style>
@endsection
