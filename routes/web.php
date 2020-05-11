<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Category
Route::get('/admin/createProduct', 'Admin\ProductController@create');
Route::get('/admin/createCategory', 'Admin\CategoryController@index');
Route::post('/admin/createCategory', 'Admin\CategoryController@store');  //action submit category
Route::get('/admin/editCategory/{id}', 'Admin\CategoryController@edit');  //แก้ไขข้อมูล  นิยาม router > Controller
Route::post('/admin/updateCategory/{id}', 'Admin\CategoryController@update');  //update category
Route::get('/admin/deleteCategory/{id}', 'Admin\CategoryController@delete');   //ลบ category



//Product
Route::get('admin/createProduct', 'Admin\ProductController@create');
Route::post('admin/createProduct', 'Admin\ProductController@store');
