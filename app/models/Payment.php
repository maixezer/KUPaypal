<?php

class Payment extends Eloquent {

	protected $table = 'payments';

	protected $fillable = array('order_id','amount', 'merchant_email', 'customer_email', 'status');

	public function user_auth($user) {
		$result = false;
		if(strtolower($user->email) == strtolower($this->merchant_email)) {
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

	public function cancel($user) {
		if($this->status == 'wait for customer authotization') 
			$status = 0;
		else if($this->status == 'wait for merchant validation')
			$status = 1;
		else $status = 2;

		if(strtolower($user->email) == strtolower($this->merchant_email) || 
			strtolower($user->email) == strtolower($this->customer_email)) {
			$this->status = 'cancelled';
			$this->save();
			if($status == 0) return true;

			$customer = User::where('email', '=', $this->customer_email)->first();
			$customer_wallet = Wallet::where('owner_id', '=', $customer->id)->first();
			$customer_wallet->balance += $this->amount;
			$customer_wallet->save();
			if($status == 1) return true;

			$merchant = User::where('email', '=', $this->merchant_email)->first();
			$merchant_wallet = Wallet::where('owner_id', '=', $merchant->id)->first();
			$merchant_wallet->balance -= $this->amount;
			$merchant_wallet->save();
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