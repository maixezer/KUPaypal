<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('wallet_trans',function($t){
			$t->increments('id');
			$t->integer('wallet_id')->unsigned();
			$t->foreign('wallet_id')->references('id')->on('wallets');
			$t->float('amount');
			$t->date('time');
			$t->string('type',10);
			$t->timestamps();
		});

		Schema::table('payments',function($t){
			$t->timestamps();
		});

		Schema::table('authenticate',function($t){
			$t->timestamps();
		});

		Schema::table('wallets',function($t){
			$t->timestamps();
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
		Schema::drop('wallet_trans');

		Schema::table('payments',function($t){
			$t->dropTimestamps();
		});

		Schema::table('authenticate',function($t){
			$t->dropTimestamps();
		});

		Schema::table('wallets',function($t){
			$t->dropTimestamps();
		});
	}

}
