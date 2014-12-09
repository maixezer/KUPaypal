<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('wallets',function($t){
			$t->increments('id');
			$t->integer('owner_id')->unsigned();
			$t->foreign('owner_id')->references('id')->on('users');
			$t->float('balance');
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
		Schema::drop('wallets');
	}

}
