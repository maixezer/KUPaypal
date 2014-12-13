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
		try{
			$user = Auth::user();
	        $statusCode = 200;
	        $wallet = Wallet::where('owner_id', '=', $user->id)->first();
	 
	        $response = [
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
