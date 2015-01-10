<?php
/**
 * Created by PhpStorm.
 * User: Amitav Roy
 * Date: 11/18/14
 * Time: 4:28 PM
 */

Route::get('login', 'UserController@getUserLoginPage');
Route::get('access-denied', 'GlobalController@handleAccessDenied');

Route::group(array('before' => 'csrf'), function() {
    Route::post('user/login', 'UserController@handleUserLogin');
});

/**
 * User related urls
 */
Route::group(array('prefix' => 'users', 'before' => 'auth'), function() {
    Route::get('logout', 'UserController@handleUserLogout');
    Route::get('dashboard', 'UserController@getUserDashboard');
    
    Route::get('view', 'UserController@getUserListing');
    Route::get('add', 'UserController@getUserAddPage');
    Route::get('delete/{id}', 'UserController@handleDeleteUser');
    Route::post('add/save', 'UserController@handleUserSave');

    Route::get('profile/view', 'UserController@getUserProfileView');
    Route::get('profile/edit', 'UserController@getUserProfileEdit');

    Route::group(array('before' => 'csrf'), function() {
        Route::post('profile/update', 'UserController@handleUserProfileUpdate');
    });

    /**
     * Groups related urls
     */
    Route::group(array('prefix' => 'groups', 'before' => 'auth'), function() {
        Route::get('manage', 'GroupsController@handleManageGroups');

        Route::group(array('before' => 'csrf'), function() {

        });
    });

    /**
     * Permissions realted urls
     */
    Route::group(array('prefix' => 'permissions', 'before' => 'auth'), function() {
        Route::get('manage', 'PermissionController@handleManagePermissions');
        Route::get('add', 'PermissionController@handleAddPermission');

        Route::group(array('before' => 'csrf'), function() {
            Route::post('save', 'PermissionController@handlePermissionSave');
            Route::post('add-new', 'PermissionController@handlePermissionAdd');
        });
    });
});

/*
 * Registering the validation
 */
Validator::resolver(function($translator, $data, $rules, $message){
    return new CustomValidation($translator, $data, $rules, $message);
});