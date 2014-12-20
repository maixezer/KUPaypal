<?php

class TestController extends \BaseController {

	public function getTest() {
		return View::make('test.payment');
	}

	public function postTest() {
		$data = Input::all();
		$amount = $data['amount'];


		$validator = Validator::make($data,
			array(
				'amount'	=> 'required|numeric'
			)
		);

		if($validator->fails()){
			return Redirect::route('payment.test')->withErrors($validator);
		}

		$payment['payment'] = [];
		$payment['amount'] = $amount;
		$payment['merchant_email'] = 'standalone_merchant@test.com';
		$payment['order_id'] = 1;
		// return Redirect::route('payment.store')->with('payment', $payment);


		// $url = 'http://128.199.212.108:8000/payment'
		// $data_string = json_encode($payment);
		// $ch = curl_init('http://128.199.212.108:8000/payment');

	 //    //set the url, number of POST vars, POST data
	 //    curl_setopt($ch, CURLOPT_POST, true);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		//     'Content-Type: application/json',
		//     'Content-Length: ' . strlen($data_string))
		// );

	 //    //execute post
	 //    curl_exec($ch);
	}
}