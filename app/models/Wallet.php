<?php

class Wallet extends Eloquent {

	protected $table = 'wallets';

	protected $fillable = array('owner_id','balance');

	public function deposite($user, $amount) {
		if($user&&$amount) {
			$wallet = getWalletByOwner($user->id);
			$wallet->amount += $amount;
			$wallet->save();
			return true;
		}
		return false;
	}

	public function withdraw($user, $amount) {
		if($user&&$amount) {
			$wallet = getWalletByOwner($user->id);
			if($wallet->balance >= $amount) {
				$wallet->balance -= $amount;
				$wallet->save();
				return true;
			}
		}
		return false;
	}

	private function getWalletByOwner($id) {
		return Wallet::where('owner_id', '=', $id)->first();
	}

}