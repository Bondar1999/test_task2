<?php

Route::get('/', function () {
	return view('main');
});

Route::post('/registration', function (){
	return view('auth/register');
});

Route::post('/authorization', function (){
	return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::put('/show', 'HomeController@show');

Route::get('/add/{tableName}', 'EditTableController@AddRow');

Route::put('/insert/{tableName}', 'EditTableController@InsertIntoTable');

Route::get('/remove/{tableName}', 'EditTableController@DeleteRow');

Route::put('remove/byId/{tableName}', 'EditTableController@DeleteRowById');

Route::get('/edit/{tableName}', 'EditTableController@EditRow');

Route::put('/update/{tableName}', 'EditTableController@EditRowById');

Route::get('/task1', 'HomeController@task1');

Route::put('/task1/search', 'TaskController@ExecuteTask1');

Route::get('/task2', 'HomeController@task2');

Route::put('task2/search', 'TaskController@ExecuteTask2');