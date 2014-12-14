<?php

/**
 * Wallet transaction resource model class.
 *
 * @author Atit Leelasuksan 5510546221, Parinthorn Panya 5510546085
 */
class Wallettrans extends Eloquent {

	/**
	 * required attribute for eloquent model.
	 */
	protected $table = 'wallet_trans';

	protected $fillable = array('wallet_id','amount','time','type');

}