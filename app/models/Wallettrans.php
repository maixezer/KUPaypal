<?php

class Wallettrans extends Eloquent {

	protected $table = 'wallet_trans';

	protected $fillable = array('wallet_id','amount','time','type');

}