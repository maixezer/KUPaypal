<?php

class WalletController extends \BaseController {

	public $restful = true;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();
		try{
	        $response = [
	            'wallets' => []
	        ];
	        $statusCode = 200;
	        $wallet = Wallet::where('owner_id', '=', $user->id)->first();
	 
	        $response['wallets'][] = [
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

	public function create()
	{
		// didn't have a view to handle this because wallet is create together with user.
	}

	public function store()
	{
		// same reason from create function.
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
	}

	public function deposit() {
		$user = Auth::user();
		$wallet = Wallet::where('owner_id', '=', $user->id)->first();
		$result = $wallet->deposit($user, 1000);
		return Redirect::route('wallets.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// do with destroy user.
	}


}
