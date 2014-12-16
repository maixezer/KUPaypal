<?php

/**
 * Controller which handle HTTP request of user resource.
 *
 * @author Atit Leelasuksan 5510546221, Parinthorn Panya 5510546085
 */
class UserController extends \BaseController {

	public $restful = true;

	/**
	 * Display currently signed in user information.
	 *
	 * @return Response with user information.
	 */
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
	 * Get HTML page for edit user information.
	 *
	 * @param  int  $id of user.
	 * @return View for edit user information.
	 */
	public function edit()
	{
		return View::make('user.edit');
	}


	/**
	 * Update the specified user from input form(receive from HTML page user.edit).
	 *
	 * @param  int  $id of user.
	 * @return Redirect to users.index which response user information.
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
				$user->urlcallback = Input::get('urlcallback');
				$user->save();

				return Redirect::route('users.profile');

			}

		}
	}

	/**
	 * Get HTML page for sign in.
	 *
	 * @return View for user to sign in.
	 */
	public function getSignIn() {
		return View::make('user.signin');
	}

	/**
	 * Post sign in information to sign in to service system.
	 *
	 * @return Success Redirect to users.index which show user information
	 *			Alternative Redirect to sign in page.
	 */
	public function postSignIn() {
		var_dump(Request::header('Referer'));
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

				return Redirect::intended('/');
			} else {
				return Redirect::route('user-sign-in')->with('fail' , 'User or Password are wrong');
			}
		}
	}

	/**
	 * Get HTML page for sign up.
	 *
	 * @return View for sign up.
	 */
	public function getSignUp() {
		return View::make('user.create');
	}

	/**
	 * Post sign up information to sign up a new user.
	 *
	 * @return Redirect to route home.
	 */
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
					'updated_at' 	=> $date,
					'urlcallback' 	=> Input::get('urlcallback'), 
					'role'		=> 'user'
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

	/**
	 * Get HTML page for sign out.
	 *
	 * @return Redirect route to home page.
	 */
	public function getSignOut() {

		if( Auth::check() ) {
			Auth::logout();
			return Redirect::route('home')->with('success','Sign out');
		}
		return Redirect::route('home')->with('fail','You are not sign in');
	}

	/**
	 * Get HTML page for user profile with balance.
	 *
	 * @return View for user profile and balance.
	 */
	public function getProfile() {
		return View::make('user.profile');
	}

}
