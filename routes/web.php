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
    // Users
    Route::get('get-auth-user', 'Api\UserController@getUser');
    Route::post('update-user-password', 'Auth\UpdatePasswordController@update');
    Route::get('get-users', 'Api\UserController@getUsers');

    // Tasks
    Route::get('get-tasks', 'Api\TaskController@getTasks');
    Route::get('get-tasks/{id}', 'Api\TaskController@getTaskById');
    Route::post('post-task', 'Api\TaskController@postTask');
    Route::post('post-task/{id}', 'Api\TaskController@editTask');
    Route::patch('post-task/{id}', 'Api\TaskController@editTaskField');
    Route::delete('post-task/{id}', 'Api\TaskController@deleteTask');
    Route::post('post-task-update', 'Api\TaskController@postTaskUpdate');
    Route::post('delete-task-update', 'Api\TaskController@deleteTaskUpdate');

    // Clients
    Route::get('get-clients', 'Api\ClientController@getClients');
    Route::post('post-client', 'Api\ClientController@postClient');
    Route::post('delete-client', 'Api\ClientController@deleteClient');

    // Projects
    Route::post('post-project/{clientId}', 'Api\ProjectController@postProject');
    Route::post('delete-project', 'Api\ProjectController@deleteProject');

    // Others
    Route::get('get-statuses', 'Api\SystemController@getStatuses');
    Route::get('get-priorities', 'Api\SystemController@getPriorities');
});

// Application routes (Laravel delegates to Vue)
Route::get('/{vue_capture?}', 'AppController@index')
    ->where('vue_capture', '[\/\w\.-]*');
