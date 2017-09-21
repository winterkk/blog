<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','IndexController@Index');

Route::get('article','ArticleController@index');
Route::get('article/{id}','ArticleController@show');

// 控制器在 "App\Http\Controllers\Admin" 命名空间下
Route::group(['namespace'=>'Admin'],function(){
	Route::get('Admin/article','ArticleController@index');
});