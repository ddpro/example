<?php
// Authentication routes START
Route::get('admin/login', [
    'as'    => 'admin.getlogin',
    'uses'  => 'Auth\AuthController@getLogin'
]);
Route::post('admin/login', [
    'as'    => 'admin.postlogin',
    'uses'  => 'Auth\AuthController@postLogin'
]);
Route::get('admin/logout', [
    'as'    => 'admin.getlogout',
    'uses'  => 'Auth\AuthController@getLogout'
]);

// Password reset link request routes...
Route::get('password/email', [
    'as'    => 'admin.getemail',
    'uses'  => 'Auth\PasswordController@getEmail'
]);
Route::post('password/email', [
    'as'    => 'admin.postemail',
    'uses'  => 'Auth\PasswordController@postEmail'
]);

// Password reset routes
Route::get('password/reset/{token}', [
    'as'    => 'admin.getreset',
    'uses'  => 'Auth\PasswordController@getReset'
]);
Route::post('password/reset', [
    'as'    => 'admin.postreset',
    'uses'  => 'Auth\PasswordController@postReset'
]);

// Authentication routes END
