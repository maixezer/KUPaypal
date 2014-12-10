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
		$data = Input::all();

		$date = new DateTime();

		if($data['type']==$withdraw||$data['type']==$deposit) {
			Wallettrans::create(array(
				'wallet_id' => $id,
				'amount' => $data['amount'],
				'time' => $date->format('Y-m-d'),
				'type' => $data['type']));

			$wallet = Wallet::find($id);
			if($data['type']==$deposit) {
				$wallet->amount += $data['amount'];
			} else {
				$wallet->amount -= $data['amount'];
			}
			$wallet->save();

			return Redirect::route('wallets.show', array('id' => $id));
		} else {
			return;
		}
	}

	public function deposite($amount) {
		$user = Auth::user();
		if($user) {
			$wallet = getWalletByOwner($user->id);
			$wallet->amount += $amount;
			$wallet->save();
			return Redirect::route('wallets.index');
		}
		return Redirect::intend('/');
	}

	public function withdraw($amount) {
		$user = Auth::user();
		if($user) {
			$wallet = getWalletByOwner($user->id);
			if($wallet->amount < $amount) 
				return Redirect::intend('/');
			$wallet->amount -= $amount;
			$wallet->save();
			return Redirect::route('wallets.index');
		}
		return Redirect::intend('/');
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
