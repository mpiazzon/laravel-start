<?php

/*
|--------------------------------------------------------------------------
| Rutas del front 
|--------------------------------------------------------------------------
|
*/


Route::get('/', function()
{
	return View::make('hello');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::get('cpanel/logout', array('as' => 'admin.logout', 'uses' => 'App\Controllers\Admin\AuthController@getLogout'));
Route::get('cpanel/login', array('as' => 'admin.login', 'uses' => 'App\Controllers\Admin\AuthController@getLogin'));
Route::post('cpanel/login', array('as' => 'admin.login.post', 'uses' => 'App\Controllers\Admin\AuthController@postLogin'));


Route::group(array('prefix' => 'cpanel', 'before' => 'auth.admin'), function()
{
		
	Route::get('/',    array('as' => 'admin.home',    'uses' => 'App\Controllers\Admin\AdminController@index'));
		
});