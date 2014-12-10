<?php

class WalletController extends \BaseController {

	public $restful = true;

	$deposit = 'deposit';
	$withdraw = 'withdraw';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try{
	        $response = [
	            'wallets' => []
	        ];
	        $statusCode = 200;
	        $wallets = Wallet::all();
	 
	        foreach($wallets as $wallet){
	 
	            $response['wallets'][] = [
	                'id' => $wallet->id,
	                'owner_id' => $wallet->owner_id,
	                'balance'  => $wallet->balance
	            ];
	        }
	 
	 
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
		try{
			$user = Auth::user();
	        $response = [
	            'wallet' => []
	        ];
	        $statusCode = 200;
	        $wallet = getWalletByOwner($id);
	        // $wallet = Wallet::find($id);
	 
	 
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
		$user = Auth::user();
		$data = Input::all();

		$date = new DateTime();

		if($data['type']==$withdraw||$data['type']==$deposit) {
			Wallettrans::create(array(
				'wallet_id' => $id,
				'amount' => $data['amount'],
				'time' => $date->format('Y-m-d'),
				'type' => $data['type']));

			$wallet = Wallet::find($id);
			$result = false;
			if($data['type']==$deposit) {
				$result = $wallet->deposit($user, $data['amount']);
			} else {
				$result = $wallet->withdraw($user, $data['amount']);
			}
			if($result)
				return Redirect::route('wallets.show', array('id' => $id));
		}
		return;
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
