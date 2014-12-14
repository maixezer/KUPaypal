<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTypeOfBalance extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('payments',function($t){
			$t->dropForeign('payments_merchant_id_foreign');
			$t->dropColumn(array('amount'));
		});
		Schema::table('wallets',function($t){
			$t->dropColumn(array('balance'));
		});
		Schema::table('wallet_trans',function($t){
			$t->dropColumn(array('amount'));
		});
		Schema::table('payments',function($t){
			$t->decimal('amount',10,2);
		});
		Schema::table('wallets',function($t){
			$t->decimal('balance',10,2);
		});
		Schema::table('wallet_trans',function($t){
			$t->decimal('amount',10,2);
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
	}

}
