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
    Route::get('get-auth-user', 'Api\UserController@getUser')->name('get-auth-user');
    Route::post('update-user-password', 'Auth\UpdatePasswordController@update')->name('update-user-password');
    Route::get('get-users', 'Api\UserController@getUsers')->name('get-users');

    // Tasks
    Route::get('get-tasks', 'Api\TaskController@getTasks')->name('get-tasks');
    Route::get('get-tasks/{id}', 'Api\TaskController@getTaskById');
    Route::post('post-task', 'Api\TaskController@postTask')->name('post-task');
    Route::post('post-task/{id}', 'Api\TaskController@editTask');
    Route::patch('post-task/{id}', 'Api\TaskController@editTaskField');
    Route::delete('post-task/{id}', 'Api\TaskController@deleteTask');
    Route::post('post-task-update', 'Api\TaskController@postTaskUpdate')->name('post-task-update');
    Route::post('delete-task-update', 'Api\TaskController@deleteTaskUpdate')->name('delete-task-update');

    // Clients
    Route::get('get-clients', 'Api\ClientController@getClients')->name('get-clients');
    Route::post('post-client', 'Api\ClientController@postClient')->name('post-client');
    Route::post('delete-client', 'Api\ClientController@deleteClient')->name('delete-client');

    // Projects
    Route::post('post-project/{clientId?}', 'Api\ProjectController@postProject')->name('post-project');
    Route::post('delete-project', 'Api\ProjectController@deleteProject')->name('delete-project');

    // Others
    Route::get('get-statuses', 'Api\SystemController@getStatuses')->name('get-statuses');
    Route::get('get-priorities', 'Api\SystemController@getPriorities')->name('get-priorities');
    Route::post('task-media-library/{taskId}', 'Api\MediaLibraryController@taskStore')->name('taskMediaLibrary');
});

// Application routes (Laravel delegates to Vue)
Route::get('/{vue_capture?}', 'AppController@index')
    ->where('vue_capture', '[\/\w\.-]*');
