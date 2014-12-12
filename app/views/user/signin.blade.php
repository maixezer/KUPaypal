@extends('layout.default')
@section('content')

    <div class="modal-dialog" style="margin-top: 150px;" >
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="">&times;</button>
          <h4 class="modal-title">KUPayPal Sign In</h4>
        </div>
        {{ Form::open(array('route' => 'user-sign-in-post' , 'method' => 'post' )) }}
          <div class="modal-body">
            
              *<span style="font-weight:bold;"> Your Email</span><br/>
              <input type="text" class="form-control" placeholder="example@example.com" name="email" /><br />
              *<span style="font-weight:bold;" > Password</span><br />
              <input type="password" class="form-control" placeholder="Password" name="password" />
          </div>
          <div class="modal-footer">
           
            <input type="submit" name="submit" class="btn btn-success btn-lg marginbot-50 btn-block" value="Sign In" >
            </br>
            <span> Not a member yet?</span>
            <span style="cursor:pointer;" class="text-info"><a href="{{ URL::route('user-sign-up')}}">Sign Up!</a></span>
          </div>

          {{ Form::token() }}
        {{ Form::close() }}
      </div> 
    </div><!-- /.modal-dialog -->
 
@endsection