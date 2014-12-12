<?php

class Payment extends Eloquent {

	protected $table = 'payments';

	protected $fillable = array('order_id','amount', 'merchant_email', 'customer_email', 'status');

	public function user_auth($user) {
		$result = false;
		if($user->email == $this->merchant_email) {
			$result = $this->merchant_validate($user);
		}
		else if($this->status == 'wait for customer authotization') {
			$result = $this->customer_authorize($user);
		}
		if($result) {
			$this->save();
			return true;
		}
		return false;
	}

	private function merchant_validate($user) {
		if($this->status == 'wait for merchant validation') {
			$this->status = 'success';
			// money tranferred.
			$merchant_wallet = Wallet::where('owner_id', '=', $user->id)->first();
			$merchant_wallet->balance += $this->amount;
			$merchant_wallet->save();
			return true;
		}
		return false;
	}

	private function customer_authorize($user) {
		//wait for merchant to validate a payment.
		$customer_wallet = Wallet::where('owner_id', '=', $user->id)->first();
		if($customer_wallet->balance >= $this->amount) {
			$this->status = 'wait for merchant validation';
			$this->customer_email = $user->email;
			$customer_wallet->balance -= $this->amount;
			$customer_wallet->save();
			return true;
		}
		return false;
	}
}