<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('payments',function($t){
			$t->increments('id');
			$t->integer('merchant_id')->unsigned();
			$t->foreign('merchant_id')->references('id')->on('users');
			$t->integer('order_id')->unsigned();
			$t->float('amount');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('payments');
	}

}
