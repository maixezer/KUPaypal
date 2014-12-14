<?php

/**
 * Controller which handle HTTP request to payment resource.
 *
 * @author Atit Leelasuksan 5510546221, Parinthorn Panya 5510546085
 */
class PaymentController extends \BaseController {

	public $restful = true;

	/**
	 * Display all payment that relate to current signed in user.
	 *
	 * @return Response with all related payment information.
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
	 * post new payment to payment system.
	 * require merchant email, order id and amount for payment.
	 *
	 * @return Success response with Location which have created payment path.
	 *			Alternative response with failure description.
	 */
	public function store()
	{	
		$id = 0;
		$statusCode = 201;
		$responseBody = '';
		$data = Input::get('payment');

		if(empty($data)) {
			return Response::make('Request body is empty.',400);
		}
		if($data['amount']<0) {
			if(User::where('email', '=', $data['merchant_email'])->first() == null && 
				User::where('email', '=', strtolower($data['merchant_email']))->first() == null) {
				return Response::make("E-mail doesn't exist or amount is negative.", 400);
			}
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
				'status' => 'wait for customer acceptance',
				'time' => $date->format('Y-m-d'),
				'created_at' => $date,
				'updated_at' => $date
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
	 * Display the specified payment.
	 *
	 * @param  int  $id of payment.
	 * @return Response with specific payment information.
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

	/**
	 * Retrieve the specific payment status.
	 *
	 * @return Response with status of payment.
	 */
	public function getStatus($id) {
		try {
			$payment = Payment::find($id);
			$response = [
				"status" => $payment->status
			];
			$responseCode = 200;
		} catch(Exception $e) {
			$responseCode = 404;
		} finally {
			return Response::json($response, $responseCode);
		}
	}

	/**
	 * Customer accept the specific payment.
	 *
	 * @return Redirect route to the specific payment information.
	 */
	public function accept($id) {
		$payment = Payment::find($id);
		$user = Auth::user();
		$result = $payment->customer_accept($user);
		if($result) {
			return Redirect::route('payment.getAccept', array('id' => $id));
		}
		return Redirect::route('payment.getAccept', array('id' => $id));
	}

	/**
	 * Merchant validate the specific payment.
	 *
	 * @return Redirect route to the specific payment information.
	 */
	public function validate($id) {
		$payment = Payment::find($id);
		$user = Auth::user();
		$result = $payment->merchant_validate($user);
		if($result) {
			return Redirect::route('payment.getValidate', array('id' => $id));
		}
		return Redirect::route('payment.getValidate', array('id' => $id));
	}

	/**
	 * Get HTML page to accept the specific payment.
	 *
	 * @return View for customer to accept the specific payment.
	 */
	public function getAccept($id) {
		return View::make('payment.show')->with('id',$id);
	}

	/**
	 * Get HTML page to validate the specific payment.
	 *
	 * @return View for merchant to validate the specific payment.
	 */
	public function getValidate($id) {
		return View::make('payment.validation')->with('id',$id);
	}

	/**
	 * User cancel the specific payment.
	 *
	 * @return Redirect route to the specific payment information.
	 */
	public function cancel($id) {
		$payment = Payment::find($id);
		$user = Auth::user();
		$result = $payment->cancel($user);
		if($result) {
			return Redirect::route('payment.show', array('id' => $id));
		}
		return Redirect::route('payment.show', array('id' => $id));
	}

}
