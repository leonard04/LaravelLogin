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
use App\Payment;
use Illuminate\Support\Facades\Input;

Route::group(['middleware' => ['web']],function(){
	///////////Route tanpa login//////////////////////
    Route::get('/', function () {
	    return view('welcome');
	})->name('home');
	Route::get('/login',[
	    'uses' => 'UserController@getLogin',
        'as' => 'login'
    ]);
    Route::get('/register',[
        'uses' => 'UserController@getRegister',
        'as' => 'register'
    ]);
    Route::post('/register',[
        'uses' => 'UserController@postSignUp',
        'as' => 'register'
    ]);
    Route::post('/login',[
        'uses' => 'UserController@postSignIn',
        'as' => 'login'
    ]);
    Route::get('/logout',[
        'uses' => 'UserController@logout',
        'as' => 'logout'
    ]);
/////////////////////////////////////////Route yang harus login///////////////////////////
///

    Route::group(['middleware' => ['auth']],function (){
        Route::get('/dashboard',[
            'uses' => 'UserController@getDashboard',
            'as' => 'dashboard'
        ]);
        Route::resource('/students','StudentController');
        Route::get('/printallstudent',[
            'uses' => 'StudentController@cetakStudent',
            'as' => 'printallstudent'
        ]);
        Route::get('/students/printbyid/{id}',[
            'uses' => 'StudentController@cetakById',
            'as' => 'students.printbyid'
        ]);
        Route::group(['middleware' => ['roles'],'roles' => ['admin']],function (){
            Route::get('/teachers/downloadExcel/{type}', [
                'uses' => 'TeacherController@exportAll',
                'as' => 'teachers.downloadExcel'
            ]);
            Route::post('/admin/assign-roles', [
                'uses' => 'UserController@postAdminAssignRoles',
                'as' => 'admin.assign'
            ]);
            Route::get('/admin', [
                'uses' => 'UserController@getAdminPage',
                'as' => 'admin'
            ]);
            Route::get('/teachers/printbyid/{id}',[
                'uses' => 'TeacherController@cetakById',
                'as' => 'teachers.printbyid'
            ]);
            Route::resource('/teachers','TeacherController');
            Route::resource('/payments','PaymentController');
            Route::resource('/recordpayments','Record_BayarController');
            Route::get('/recordpayments/downloadExcel/{type}',[
                'uses' => 'Record_BayarController@exportAll',
                'as' => 'recordpayments.downloadExcel'
            ]);
            Route::post('search','PaymentController@search');
            Route::post('searchByDate','Record_BayarController@search');
            Route::get('/printallteacher',[
                'uses' => 'TeacherController@cetakTeacher',
                'as' => 'printallteacher'
            ]);
            Route::get('/teachers/printbyid/{id}',[
                'uses' => 'TeacherController@cetakById',
                'as' => 'teachers.printbyid'
            ]);
        });
    });
    //end of post put delete method
});