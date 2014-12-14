<?php

class Wallet extends Eloquent {

	protected $table = 'wallets';

	protected $fillable = array('owner_id','balance');

	// can't create final attribute
	// protected $deposit = 'deposit';
	// protected $withdraw = 'withdraw';

	public function deposit($user, $amount) {
		if($user->id!=$this->owner_id) return false;
		$date = new DateTime();
		Wallettrans::create( array(
			'wallet_id' => $this->id,
			'amount' => $amount,
			'time' => $date->format('Y-m-d'),
			'type' => 'deposit'
		));
		$bal = $this->balance;
		$this->balance = $bal+$amount;
		$this->save();
		return true;
	}

	public function withdraw($user, $amount) {
		if($user&&$amount) {
			if($this->balance >= $amount) {
				$bal = $this->balance;
				$this->balance = $bal - $amount;
				$this->save();
				return true;
			}
		}
		return false;
	}

}