<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('authenticate',function($t){
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->foreign('user_id')->references('id')->on('users');
			$t->string('email',100);
			$t->string('password',64);
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
		Schema::drop('authenticate');
	}

}
