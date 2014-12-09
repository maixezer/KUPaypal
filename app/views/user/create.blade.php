@extends('layout.default')
@section('content')

        {{ Form::open( array('route' => 'user-sign-up-post' , 'method' => 'post') )}}
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
	          <input type="text" class="form-control" name="first_name"/>
	          @if($errors->has('first_name'))
					<p class="imt">{{ $errors->first('first_name') }}</p>
			  @endif 
	          </br>

	          <span class="imt">*</span><span > Last Name</span>
	          <input type="text" class="form-control" name="last_name"/> 
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

	          <span class="imt">*</span><span> Phone Number </span> <input type="text" class="form-control" name="phone"/> 
	          @if($errors->has('phone'))
					<p class="imt">{{ $errors->first('phone') }}</p>
			  @endif

	       {{ Form::submit('Submit',array('class' => 'btn btn-success'))}}

     	{{ Form::token() }}
     	{{ Form::close() }}

    <style type="text/css">
    	.imt {
    		color: red;
    	}
    </style>
@endsection
