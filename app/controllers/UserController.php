<?php

class UserController extends \BaseController {

	public $restful = true;

	public function index()
	{
		try{
			$user = Auth::user();
	        $statusCode = 200;
	        $users = User::where('id', '=', $user->id);
	 
	        $response['user'][] = [
	            'id' => $user->id,
	            'first_name' => $user->first_name,
	            'last_name' => $user->last_name,
	            'date_of_birth' => $user->date_of_birth,
	            'phone' => $user->phone,
	            'address' => $user->address
	        ];
	
	    }catch (Exception $e){
	        $statusCode = 404;
	    }finally{
	        return Response::json($response, $statusCode);
	    }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		return View::make('user.edit');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$user = Auth::user();

		if($user) {
			$dob = new DateTime(Input::get('year'). '-' .Input::get('month') . '-' . Input::get('day'));

			$validator = Validator::make(Input::all(),
				array(
					'first_name'	=> 'required',
					'last_name'		=> 'required',
					'address'		=> 'required',
					'phone'			=> 'required'
				)
			);

			if($validator->fails()){
				return Redirect::route('users.edit' , array('id' => $id ))
					   ->withErrors($validator)
					   ->withInput();
			} else {

				$user->first_name = Input::get('first_name');
				$user->last_name = Input::get('last_name');
				$user->address  = Input::get('address');
				$user->phone  = Input::get('phone');
				$user->date_of_birth = $dob->format('Y-m-d');
				$user->save();

				return Redirect::route('users.index');

			}

		}
	}


	public function getDestroy() {
		// create a view that wait for user confirmation.
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// handle http delete request to destroy user.
	}

	public function getSignIn() {
		return View::make('user.signin');
	}

	public function postSignIn() {

		$validator = Validator::make(Input::all(),
			array(
				'email' 	=> 'required|email|exists:users',
				'password'  => 'required|min:8'
			)
		);

		if($validator->fails()){
			return Redirect::route('user-sign-in')
				   ->withErrors($validator)
				   ->withInput(Input::except('password'));
		} else {

			$credentials = array(
				'email'		=> Input::get('email'),
				'password'	=> Input::get('password')
			);

			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt($credentials,$remember);

			if($auth) {
				//Redirect to the intended page

				Session::put('user' , Auth::user() );

				return Redirect::route('users.profile');
			} else {
				return Redirect::route('user-sign-in')->with('fail' , 'User or Password are wrong');
			}
		}
	}

	public function getSignUp() {
		return View::make('user.create');
	}

	public function postSignUp() {
		$validator = Validator::make(Input::all(),
			array(
				'email' 				=> 'required|max:50|email|unique:users',
				'password'  			=> 'required|min:8',
				'password_confirmation' => 'required|same:password',
				'first_name'			=> 'required',
				'last_name'				=> 'required',
				'address'				=> 'required',
				'phone'					=> 'required'
			)
		);

		if($validator->fails()){
			return Redirect::route('user-sign-up')
				   ->withErrors($validator)
				   ->withInput();
		} else {

			$dob = new DateTime(Input::get('year'). '-' .Input::get('month') . '-' . Input::get('day'));

			$date = new DateTime();

			$id = DB::table('users')->insertGetId(
				array(
					'first_name'=> Input::get('first_name'),
					'last_name'	=> Input::get('last_name'),
					'address'	=> Input::get('address'),
					'phone'		=> Input::get('phone'),
					'date_of_birth' => $dob->format('Y-m-d'),
					'email' 	=> Input::get('email'),
					'password'	=> Hash::make(Input::get('password')),
					'created_at' 	=> $date,
					'updated_at' 	=> $date
				)
			);

			DB::table('wallets')->insert(
				array(
					'owner_id' => $id,
					'balance'  => 0,
					'created_at' 	=> $date,
					'updated_at' 	=> $date
				)
			);

			return Redirect::route('home')->with('success','Sign Up Success');
		}
	}

	public function getSignOut() {

		if( Auth::check() ) {
			Auth::logout();
			return Redirect::route('home')->with('success','Sign out');
		}
		return Redirect::route('home')->with('fail','You are not sign in');
	}

	public function getProfile() {
		return View::make('user.profile');
	}

}
