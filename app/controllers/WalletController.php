<?php

/**
 * Controller which handle HTTP request of wallet resource.
 *
 * @author Atit Leelasuksan 5510546221, Parinthorn Panya 5510546085
 */
class WalletController extends \BaseController {

	public $restful = true;

	/**
	 * Display a wallet from current signed in user.
	 *
	 * @return Response with wallet information.
	 */
	public function index()
	{
		try{
			$user = Auth::user();
	        $statusCode = 200;
	        $wallet = Wallet::where('owner_id', '=', $user->id)->first();
	        $response['wallet'][] = [
	            'id' => $wallet->id,
	            'owner_id' => $wallet->owner_id,
	            'balance'  => $wallet->balance
	        ];
	 
	 
	    }catch (Exception $e){
	        $statusCode = 404;
	    }finally{
	        return Response::json($response, $statusCode);
	    }
	}

	/**
	 * Deposit money
	 *
	 * @return Success Redirect route to users.profile page which have user profile and balance.
	 *			Alternative Redirect with error message.
	 */
	public function deposit() {
		$user = Auth::user();
		$input = Input::all();
		$amount = floatval($input['amount']);

		if( is_null($amount) || $amount <= 0 || $amount == '' ) 
			return Redirect::route('users.profile')->with('fail','Whoops! Something wrong!!!');  

		$wallet = Wallet::where('owner_id', '=', $user->id)->first();
		$wallet->deposit($user, $amount);
		return Redirect::route('users.profile');
	}

}
