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
    Route::get('get-auth-user', 'InternalApiController@getUser')->name('getUser');
    Route::post('update-user-password', 'Auth\UpdatePasswordController@update')->name('updatePassword');
    Route::get('get-tasks/{id}', 'InternalApiController@getTaskById');
    Route::get('get-tasks', 'InternalApiController@getTasks')->name('getTasks');
    Route::get('get-users', 'InternalApiController@getUsers')->name('getUsers');
    Route::get('get-clients', 'InternalApiController@getClients')->name('getClients');
    Route::get('get-statuses', 'InternalApiController@getStatuses')->name('getStatuses');
    Route::get('get-severities', 'InternalApiController@getSeverities')->name('getSeverities');
    Route::post('post-task', 'InternalApiController@postTask')->name('postTask');
    Route::post('post-task-update', 'InternalApiController@postTaskUpdate')->name('postTaskUpdate');
    Route::post('post-task/{id}', 'InternalApiController@editTask');
    Route::post('post-contact', 'InternalApiController@postContact')->name('postContact');
    Route::post('sync-provider-contact', 'InternalApiController@syncProviderToProject')->name('syncProviderToProject');
    Route::post('post-client', 'InternalApiController@postClient')->name('postClient');
    Route::post('post-project', 'InternalApiController@postProject')->name('postProject');
    Route::post('delete-client', 'InternalApiController@deleteClient')->name('deleteClient');
    Route::post('delete-project', 'InternalApiController@deleteProject')->name('deleteProject');
});

// Application routes (Laravel delegates to Vue)
Route::get('/{vue_capture?}', 'AppController@index')
    ->where('vue_capture', '[\/\w\.-]*');
