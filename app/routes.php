<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


	Route::resource('users','UserController');

	/*
		Authenticated group
	*/
	Route::group(array('before' => 'auth'),function(){

		/*
			CSRF protection group
		*/
		Route::group( array('before' => 'csrf') , function(){

			Route::resource('wallets','WalletController');
			Route::resource('payment', 'PaymentController');


		});

	});

	/*
		Unauthenticated group
	*/
	Route::group( array('before' => 'guest'), function(){

		/*
			CSRF protection group
		*/
		Route::group( array('before' => 'csrf') , function(){

			Route::post('/user/sign_in',array(
				'as' => 'user-sign-in-post',
				'uses' => 'UserController@postSignIn'
			));

		});

		Route::get('/user/sign_in' ,array(
			'as' => 'user-sign-in',
			'uses' => 'UserController@getSignIn'
		));


	});

