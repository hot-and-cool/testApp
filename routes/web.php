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

/** getやresourceの第一引数で指定したURIと
 * クライアントからのリクエストが一致すれば、第二引数を実行する
 * 第一引数は ドメイン/第一引数  */

Route::get('/', function () {
    return view('welcome');
}); //初期ページ
Route::resource('todo', 'TodoController');
/** routelistのuri todoに遷移 TodoControllerを呼び出す
 * resourceメソッドでcontrollerのcrudアクションへのルートを割り振ってくれる
*/

Auth::routes();
//Route::auth();でも良い

Route::get('/home', 'HomeController@index')->name('home');
