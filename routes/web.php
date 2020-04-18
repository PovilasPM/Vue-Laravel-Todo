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
    return view('main');
});

//Routes for AJAX calls to CRUD;

route::get('todo_data', 'TodoController@todo'); //get todo data;
route::get('archive_data', 'TodoController@archive'); //get archived data;
route::post('create_todo', 'TodoController@create'); //create data;
route::post('update_todo/{id}', 'TodoController@update') ;//update data;
route::post('delete_todo/{id}', 'TodoController@delete') ;//delete data;
