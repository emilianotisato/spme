<?php

Route::get('', 'AppController@index');

// Auth routes
Route::get('login', 'AppController@index')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password_reset');
Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password_email');
Route::get('resetpass', 'AppController@resetpass');
//Auth::routes();

// Internal Api
Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('get-auth-user', 'Api\UserController@getUser')->name('getUser');
    Route::post('update-user-password', 'Auth\UpdatePasswordController@update')->name('updatePassword');
    Route::get('get-users', 'Api\UserController@getUsers')->name('getUsers');
    Route::get('get-tasks/{id}', 'Api\TaskController@getTaskById');
    Route::get('get-tasks', 'Api\TaskController@getTasks')->name('getTasks');
    Route::post('post-task', 'Api\TaskController@postTask')->name('postTask');
    Route::post('post-task-update', 'Api\TaskController@postTaskUpdate')->name('postTaskUpdate');
    Route::post('post-task/{id}', 'Api\TaskController@editTask');
    Route::get('get-clients', 'Api\ClientController@getClients')->name('getClients');
    Route::post('post-client', 'Api\ClientController@postClient')->name('postClient');
    Route::post('delete-client', 'Api\ClientController@deleteClient')->name('deleteClient');
    Route::post('post-project', 'Api\ProjectController@postProject')->name('postProject');
    Route::post('delete-project', 'Api\ProjectController@deleteProject')->name('deleteProject');
    Route::get('get-statuses', 'Api\SystemController@getStatuses')->name('getStatuses');
    Route::get('get-priorities', 'Api\SystemController@getPriorities')->name('getPriorities');
});

// Application routes (Laravel delegates to Vue)
Route::get('/{vue_capture?}', 'AppController@index')
    ->where('vue_capture', '[\/\w\.-]*');
