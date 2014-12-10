<?php

class Payment extends Eloquent {

	protected $table = 'payments';

	protected $fillable = array('merchant_id','order_id','amount', 'merchant_email', 'customer_email');

	private $wait_customer = 'wait for customer authotization';
	private $wait_merchant = 'wait for merchant validation';
	private $success = 'success';

	public function user_auth($user, $payment) {
		if($user->email == $payment->merchant_email) {
			$payment = merchant_validate($user, $payment);
		}
		else if($user->email == $payment->customer_email) {
			$payment = customer_authorize($user, $payment);
		}
		if($payment) {
			$payment->save();
			return true;
		}
		return false;
	}

	private function merchant_validate($user, $payment) {
		if($payment->status == $wait_merchant) {
			$payment->status = $success;
			// money tranferred.
			$merchant_wallet = find_wallet_from_owner($user->id);
			$merchant_wallet->balance += $payment->amount;
			return $payment;
		}
		return null;
	}

	private function customer_authorize($user, $payment) {
		if($payment->status == $wait_customer) {
			$payment->status = $wait_merchant;
			$payment->customer_email = $user->email;
			//wait for merchant to validate a payment.
			$customer_wallet = find_wallet_from_owner($user->id);
			if($customer_wallet->balance >= $payment->amount) {
				$customer_wallet->balance -= $payment->amount;
				return $payment;
			}
		}
		return null;
	}

	private function find_wallet_from_owner($id) {
		return Wallet::where('owner_id', '=', $id)->first();
	}
}