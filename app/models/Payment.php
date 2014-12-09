<?php

class Payment extends Eloquent {

	protected $table = 'payments';

	protected $fillable = array('merchant_id','order_id','amount');

}