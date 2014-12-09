<?php

class Wallet extends Eloquent {

	protected $table = 'wallets';

	protected $fillable = array('owner_id','balance');

}