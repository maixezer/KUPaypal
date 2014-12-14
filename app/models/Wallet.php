<?php

/**
 * Wallet resource model class.
 *
 * @author Atit Leelasuksan 5510546221, Parinthorn Panya 5510546085
 */
class Wallet extends Eloquent {

	/**
	 * required attribute for eloquent model.
	 */
	protected $table = 'wallets';

	protected $fillable = array('owner_id','balance');

	/**
	 * User deposit money.
	 *
	 * @return true if user deposit money successful
	 *			false otherwise.
	 */
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

	/**
	 * User withdraw money.
	 *
	 * @return true if user withdraw money successful
	 *			false otherwise.
	 */
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