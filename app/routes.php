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

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@home')
);

/*
	Payment
*/
Route::post('/payment', array(
	'as' => 'payment.store',
	'uses' => 'PaymentController@store'
));			

Route::get('/payment/{payment}/status', array(
	'as' => 'payment.status',
	'uses' => 'PaymentController@getStatus'
));

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

			Route::post('/use/register', array(
				'as' => 'user-sign-up-post',
				'uses' => 'UserController@postSignUp'
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

	});


		
	/*
		Authenticated group
	*/
	Route::group(array('before' => 'auth'),function(){

		/*
			Users group
			create and store users belong to guest group.
		*/
		Route::get('/user', array(
			'as' => 'users.index',
			'uses' => 'UserController@index'
		));
		Route::get('/user/edit', array(
			'as' => 'users.edit',
			'uses' => 'UserController@edit'
		));
		Route::get('/user/profile',array(
			'as' => 'users.profile',
			'uses' => 'UserController@getProfile'
		));
		Route::put('/user/{users}', array(
			'as' => 'users.update',
			'uses' => 'UserController@update'
		));
		Route::delete('/user/{users}', array(
			'as' => 'users.destroy',
			'uses' => 'UserController@destroy'
		));
		/*
			sign out route
		*/
		Route::get('/user/sign_out', array(
			'as' => 'user-sign-out',
			'uses' => 'UserController@getSignOut'
		));

		//Route::resource('wallets','WalletController');

		/*
			wallet & wallet transaction group
		*/
		Route::get('/wallet', array(
			'as' => 'wallets.index',
			'uses' => 'WalletController@index'
		));
		Route::put('/wallet/deposit', array(
			'as' => 'wallets.deposit',
			'uses' => 'WalletController@deposit'
		));

		/*
			Payment group
		*/
		Route::get('payment/list',array(
			'as' => 'payment.list',
			'uses' => 'PaymentController@showList'
		));

		Route::get('/payment', array(
			'as' => 'payment.index',
			'uses' => 'PaymentController@index'
		));
		Route::get('/payment/{payment}', array(
			'as' => 'payment.show',
			'uses' => 'PaymentController@show'
		));
		Route::delete('/payment/{payment}', array(
			'as' => 'payment.delete',
			'uses' => 'PaymentController@destroy'
		));
		Route::put('payment/{payment}/accept', array(
			'as' => 'payment.putAccept',
			'uses' => 'PaymentController@accept'
		));
		Route::put('payment/{payment}/validate', array(
			'as' => 'payment.putValidate',
			'uses' => 'PaymentController@validate'
		));
		Route::get('payment/{payment}/cancel', array(
			'as' => 'payment.cancel',
			'uses' => 'PaymentController@cancel'
		));
		Route::get('payment/{payment}/accept', array(
			'as' => 'payment.getAccept',
			'uses' => 'PaymentController@getAccept'
		));
		Route::get('payment/{payment}/validate', array(
			'as' => 'payment.getValidate',
			'uses' => 'PaymentController@getValidate'
		));		
		
	});



