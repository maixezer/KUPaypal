<?php

class PaymentController extends \BaseController {

	public $restful = true;

	private $wait_customer = 'wait for customer authotization';
	private $wait_merchant = 'wait for merchant validation';
	private $success = 'success';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try{
			$user = Auth::user();
	        $response = [
	            'payments' => []
	        ];
	        $statusCode = 200;
	        $payments = Payment::all();
	 
	        foreach($payments as $payment){
	 			if ($user->email == $payment->merchant_email || $user->email == $payment->customer_email) {
	            	$response['payments'][] = [
	                	'id' => $payment->id,
	                	'owner_id' => $payment->merchant_id,
	                	'order_id' => $payment->order_id,
	                	'amount' => $payment->amount,
	                	'status' => $payment->status,
	                	'time' => $payment->time
	            	];
	        	}
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
		// view that have information to create a payment
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$url = Request::url();

		$data = Input::all();

		$date = new DateTime();
		// $text = [
		// 	'text' => $data['merchant_email']
		// ];
		// return Response::json($text,200);
		$id = DB::table('payments')->insertGetId(
			array(
				'merchant_email' => $data['merchant_email'],
				'merchant_id' => $data['merchant_id'],
				'customer_email' => 'none',
				'order_id' => $data['order_id'],
				'amount' => $data['amount'],
				'status' => 'wait for customer authotization',
				'time' => $date->format('Y-m-d')
			)
		);

		// Payment::create(array(
		// 	'merchant_email' => $data['merchant_email'],
		// 	'order_id' => $data['order_id'],
		// 	'amount' => $data['amount'],
		// 	'status' => 'wait for merchant validation',
		// 	'time' => $date->format('Y-m-d')
		// ));
		// $payment = Payment::where('merchant_email', '=', $data['merchant_email'])
		// 	->where('order_id', '=', $data['order_id'])->first();
		if($id>0) {
			$response = Response::make('', 201);
			$response->header('Location', $url.'/'.$id);
			return $response;
		}
		return Response::make('', 409);
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
	            'payment' => []
	        ];
	        $statusCode = 200;
	        $payment = Payment::find($id);
	        $response['payment'][] = [
	            'id' => $payment->id,
	            'merchant_id' => $payment->merchant_id,
	            'order_id' => $payment->order_id,
	            'amount' => $payment->amount,
	            'status' => $payment->status,
	            'time' => $payment->time
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
		// didn't use, because we only need customer authorization and merchant validation.
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

	public function authorize($id) {
		$payment = Payment::find($id);
		var_dump($payment);
		$user = Auth::user();
		$result = $payment->user_auth($user);
		if($result) {
			return Redirect::route('payment.show', array('id' => $id));
		}
		return Redirect::route('payment.show', array('id' => $id));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// didn't have to remove/destroy a payment. because we can mark it to be a cancelled or reversed one.
	}


}
