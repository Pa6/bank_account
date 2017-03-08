<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix'=>'api/v1'],function(){
Route::resource('users', 'Api\UsersController');
Route::resource('deposits', 'Api\DepositController');
Route::resource('withdraws', 'Api\WithdrawController');
Route::resource('balances', 'Api\BalanceController',['only'=>['index','show']]);
});
