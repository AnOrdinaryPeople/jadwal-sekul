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
Route::get('/', 'HomeController@home');
Route::group(['prefix' => '/home'], function(){
	Route::get('/','HomeController@index');
	Route::get('/teacher','HomeController@teacher');
	Route::get('/teacher/edit/{id}','TeacherController@editView');
	Route::get('/list','HomeController@list');
	Route::get('/download','Download@export');
	Route::get('/list/{data}','HomeController@list');
	Route::get('/{data}','HomeController@index');
	Route::get('/{data}/{day}','HomeController@day');
	Route::post('/{data}/list','AjaxController@list');
});

Route::group(['prefix' => '/process'], function(){
	Route::post('/teacher/search/','TeacherController@search');
	Route::post('/addTeacher','ProcessController@addTeacher');
	Route::post('/add','ProcessController@listProcess');
	Route::delete('/delete/{id}','ProcessController@delete');
	Route::delete('/delete/teacher/{nama}/{id_kelas}/{hari}','ProcessController@deleteAsName');
});

Route::group(['prefix' => '/process/delete/teacher'], function(){
	Route::post('/','TeacherController@delete');
	Route::post('/name','TeacherController@delete');
	Route::post('/name/lesson','TeacherController@delete');
});

Route::group(['prefix' => '/home/teacher/edit/{id}'], function(){
	Route::post('/name','TeacherController@editName');
	Route::get('/matpel','TeacherController@editMatpel');
	Route::post('/process/matpel','TeacherController@updateMatpel');
	Route::post('/addBusy','TeacherController@addBusy');
	Route::post('/deleteBusy','TeacherController@deleteBusy');
});