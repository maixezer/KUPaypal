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
	 			if (strtolower($user->email) == strtolower($payment->merchant_email) || 
	 				strtolower($user->email) == strtolower($payment->customer_email)) {
	            	$response['payments'][] = [
	                	'id' => $payment->id,
	                	'merchant_email' => $payment->merchant_email,
	                	'customer_email' => $payment->customer_email,
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
		$id = 0;
		$statusCode = 201;
		$responseBody = '';
		$data = Input::get('payment');

		$validator = Validator::make($data,
				array(
					'merchant_email' => 'required|max:50|email|unique:users',
					'order_id'	=> 'required',
					'amount'	=> 'regex:{^[0-9]{1,3}$}'
				)
			);


		if(empty($data)) {
			return Response::make('Request body is empty.',400);
		}
		if($validator->fails()) {
			return Response::make("E-mail doesn't exist or amount is negative.", 400);
		}

		// $merchant = User::where('email', '=', $data['merchant_email'])->first();

		// if($merchant == null) {
		// 	return Response::make("Merchant email doesn't exist.", 400);
		// }

		$url = Request::url();

		$date = new DateTime();

		$id = DB::table('payments')->insertGetId(
			array(
				'merchant_email' => $data['merchant_email'],
				'customer_email' => 'none',
				'order_id' => $data['order_id'],
				'amount' => $data['amount'],
				'status' => 'wait for customer authotization',
				'time' => $date->format('Y-m-d')
			)
		);

		if($id>0) {
			$response = Response::make($responseBody, $statusCode);
			$response->header('Location', $url.'/'.$id);
			return $response;
		}
		$statusCode = 400;
		return Response::make($responseBody.$id, $statusCode);
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
	            'merchant_email' => $payment->merchant_email,
	            'customer_email' => $payment->customer_email,
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

	public function authorize($id) {
		$payment = Payment::find($id);
		$user = Auth::user();
		$result = $payment->user_auth($user);
		if($result) {
			return Redirect::route('payment.show', array('id' => $id));
		}
		return Redirect::route('payment.show', array('id' => $id));
	}

	public function getAccept($id) {
		return View::make('payment.show')->with('id',$id);
	}

	public function getValidate($id) {
		return View::make('payment.validation')->with('id',$id);
	}

	public function cancel($id) {
		$payment = Payment::find($id);
		$user = Auth::user();
		$result = $payment->cancel($user);
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
