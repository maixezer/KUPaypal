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


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

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
	        $response = [
	            'wallet' => []
	        ];
	        $statusCode = 200;
	        $wallet = Wallet::find($id);
	 
	 
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


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
