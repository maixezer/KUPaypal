<?php

/**
 * Payment resource model class.
 *
 * @author Atit Leelasuksan 5510546221, Parinthorn Panya 5510546085
 */
class Payment extends Eloquent {

	/**
	 * required attribute for eloquent model.
	 */
	protected $table = 'payments';

	protected $fillable = array('order_id','amount', 'merchant_email', 'customer_email', 'status');

	/**
	 * cancel payment, only merchant can cancel.
	 * function will reverse all operation that payment has done before cancel and marked payemnt as cancelled.
	 *
	 * @return true if it can reverse all operation
	 *			false otherwise.
	 */
	public function cancel($user) {
		if($this->status == 'wait for customer authotization') 
			$status = 0;
		else if($this->status == 'wait for merchant validation')
			$status = 1;
		else $status = 2;

		if(strtolower($user->email) == strtolower($this->merchant_email)) {
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

	/**
	 * merchant validate the specific payment to retreive money from customer.
	 *
	 * @return true if merchant validated
	 *			false otherwise.
	 */
	public function merchant_validate($user) {
		if(strtolower($user->email) != strtolower($this->merchant_email)) return false;
		if($this->status == 'wait for merchant validation') {
			$this->status = 'success';
			$this->save();
			// money tranferred.
			$merchant_wallet = Wallet::where('owner_id', '=', $user->id)->first();
			$merchant_wallet->balance += $this->amount;
			$merchant_wallet->save();
			return true;
		}
		return false;
	}

	/**
	 * customer accept the specific payment to hold his/her money 
	 * and wait for merchant to validate the payment.
	 *
	 * @return true if customer can accept the specific payment
	 *			false otherwise.
	 */
	public function customer_accept($user) {
		if($this->status != 'wait for customer acceptance') return false;
		$customer_wallet = Wallet::where('owner_id', '=', $user->id)->first();
		if($customer_wallet->balance >= $this->amount) {
			$this->status = 'wait for merchant validation';
			$this->customer_email = $user->email;
			$this->save();
			$customer_wallet->balance -= $this->amount;
			$customer_wallet->save();
			return true;
		}
		return false;
	}
}