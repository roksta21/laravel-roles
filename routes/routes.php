<?php

Route::group([
	'prefix' => config('permissions.route_path_prefix').'/permissions', 
	'as' => config('permissions.route_name_prefix').'permissions.', 
	'namespace' => config('permissions.controller_namespace'),
	'middleware' => ['web']
], function() {
	Route::resource('users', 'UserPermissionsController');
	Route::resource('roles', 'RolePermissionsController');
});