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
	'uses' => 'HomeController@main'));

Route::get('/detail', array(
	'as' => 'detail',
	'uses' => 'DetailController@picture'));

Route::get('/search', array(
	'as' => 'search',
	'uses' => 'SearchController@main'));

Route::get('/e-voting/{pictureCategory?}', array(
	'as' => 'e-voting',
	'uses' => 'EVotingController@main'))
	->where('pictureCategory', 'food|nature|animals|abstract');

Route::get('/e-voting/detail', array(
	'as' => 'e-voting-detail',
	'uses' => 'DetailController@eVotingPicture'));

Route::get('/most-popular/{pictureCategory?}', array(
	'as' => 'most-popular',
	'uses' => 'MostPopularController@main'))
	->where('pictureCategory', 'food|nature|animals|abstract');

Route::get('/login', array(
	'as' => 'login',
	'uses' => 'LoginController@showLogin'));

Route::post('/login', array(
	'before' => 'csrf',
	'as' => 'login',
	'uses' => 'LoginController@login'));

Route::get('/logout', array(
	'as' => 'logout',
	'uses' => 'LoginController@logout'));

Route::get('/forgot_password', array(
	'as' => 'forgot_password',
	'uses' => 'LoginController@showForgotPassword'));

Route::post('/forgot_password', array(
	'before' => 'csrf',
	'as' => 'forgot_password',
	'uses' => 'LoginController@forgotPassword'));

Route::get('/reset_password', array(
	'as' => 'reset-password',
	'uses' => 'LoginController@showResetPassword'));

Route::post('/reset_password', array(
	'before' => 'csrf',
	'as' => 'reset_password',
	'uses' => 'LoginController@resetPassword'));

Route::get('/register', array(
	'as' => 'register',
	'uses' => 'RegisterController@main'));

Route::post('/register', array(
	'before' => 'csrf',
	'as' => 'register',
	'uses' => 'RegisterController@register'));

Route::get('/your-account', array(
	'before' => 'auth.photoduels',
	'as' => 'your-account',
	'uses' => 'UploadController@main'));

Route::get('/your-account/detail', array(
	'before' => 'auth.photoduels',
	'as' => 'your-account-detail',
	'uses' => 'DetailController@accountPicture'));

Route::get('/your-account/uploads', array(
	'before' => 'auth.photoduels',
	'as' => 'your-account-uploads',
	'uses' => 'UploadController@main'));

Route::get('/your-account/uploads/add', array(
	'before' => 'auth.photoduels',
	'as' => 'your-account-uploads-add',
	'uses' => 'UploadController@showAdd'));

Route::post('/your-account/uploads/add', array(
	'before' => array('auth.photoduels', 'csrf'),
	'as' => 'your-account-uploads-add',
	'uses' => 'UploadController@add'));

Route::get('/your-account/uploads/edit', array(
	'before' => 'auth.photoduels',
	'as' => 'your-account-uploads-edit',
	'uses' => 'UploadController@showEdit'));

Route::post('/your-account/uploads/edit', array(
	'before' => array('auth.photoduels', 'csrf'),
	'as' => 'your-account-uploads-edit',
	'uses' => 'UploadController@edit'));

Route::get('/your-account/uploads/delete', array(
	'before' => 'auth.photoduels',
	'as' => 'your-account-uploads-delete',
	'uses' => 'UploadController@showDelete'));

Route::post('/your-account/uploads/delete', array(
	'before' => array('auth.photoduels', 'csrf'),
	'as' => 'your-account-uploads-delete',
	'uses' => 'UploadController@delete'));

Route::get('/your-account/profile', array(
	'before' => 'auth.photoduels',
	'as' => 'your-account-profile',
	'uses' => 'ProfileController@main'));

Route::post('/your-account/profile', array(
	'before' => array('auth.photoduels', 'csrf'),
	'as' => 'your-account-profile',
	'uses' => 'ProfileController@update'));

