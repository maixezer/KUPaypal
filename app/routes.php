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

/*
		Unauthenticated gro//up
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

		/*
			create and store user
		*/
		Route::get('/user/register', array(
			'as' => 'user-sign-up',
			'uses' => 'UserController@getSignUp'
		));
		Route::post('/user/register', array(
				'as' => 'users-sign-up-post',
				'uses' => 'UserController@postSignUp'
		));

	});


		
	/*
		Authenticated group
	*/
	Route::group(array('before' => 'auth'),function(){

		/*
			CSRF protection group
		*/
		Route::group( array('before' => 'csrf') , function(){


			/*
				Users group
				create and store users belong to guest group.
			*/
			// Route::get('/users', array(
			// 		'as' => 'users.index',
			// 		'uses' => 'UserController@index'
			// ));
			// Route::get('/users/{users}', array(
			// 		'as' => 'users.show',
			// 		'uses' => 'UserController@show'
			// ));
			// Route::get('/users/{users}/edit', array(
			// 		'as' => 'users.edit',
			// 		'uses' => 'UserController@edit'
			// ));
			// Route::put('/users/{users}', array(
			// 		'as' => 'users.update',
			// 		'uses' => 'UserController@update'
			// ));
			// Route::delete('/users/{users}', array(
			// 		'as' => 'users.destroy',
			// 		'uses' => 'UserController@destroy'
			// ));
			Route::resource('users', 'UserController');


			/*
				wallet & wallet transaction group
			*/
			// Route::get('/wallets', array(
			// 		'as' => 'wallets.index',
			// 		'uses' => 'WalletController@index'
			// ));
			// Route::post('/wallets', array(
			// 		'as' => 'wallets.store',
			// 		'uses' => 'WalletController@store'
			// ));
			// Route::get('/wallets/{wallets}', array(
			// 		'as' => 'wallets.show',
			// 		'uses' => 'WalletController@show'
			// ));
			// Route::get('/wallets/{wallets}/edit', array(
			// 		'as' => 'wallets.edit',
			// 		'uses' => 'WalletController@edit'
			// ));
			// Route::put('/wallets/{wallets}', array(
			// 		'as' => 'wallets.update',
			// 		'uses' => 'WalletController@update'
			// ));
			// Route::delete('/wallets/{wallets}', array(
			// 		'as' => 'wallets.destroy',
			// 		'uses' => 'wallets.destroy'
			// ));

			/*
				Payment group
			*/
			// Route::get('/payment', array(
			// 		'as' => 'payment.index',
			// 		'uses' => 'PaymentController@index'
			// ));
			// Route::post('/payment', array(
			// 		'as' => 'payment.store',
			// 		'uses' => 'PaymentController@store'
			// ));
			// Route::get('/payment/{payment}', array(
			// 		'as' => 'payment.show',
			// 		'uses' => 'PaymentController@show'
			// ));
			// Route::put('/payment/{payment}', array(
			// 		'as' => 'payment.update',
			// 		'uses' => 'PaymentController@update'
			// ));
			// Route::delete('/payment/{payment}', array(
			// 		'as' => 'payment.delete',
			// 		'uses' => 'PaymentController@destroy'
			// ));

			Route::resource('wallets','WalletController');
			Route::resource('payment', 'PaymentController');


		});

	});



