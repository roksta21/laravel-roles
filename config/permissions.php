<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Super Admin Settings
    |--------------------------------------------------------------------------
    |
    | This option sets the super admin user id that will be given full access rights to the system
    | The user must exist in the user's table and will be responsible for granting other user's 
    | permissions. 
    |
    | expects @integer
    |
    */
    'super_admin_user_id' => 1,

    /*
    |--------------------------------------------------------------------------
    | Routes with permissions
    |--------------------------------------------------------------------------
    |
    | This option defines the routes that are to be protected by permissions. The routes must be
    | named and this prefix will be used to filter the routes and set them as protected. The  
    | route_name_prefix is the name prefix whereas route_path_prefix is the path/url prefix
    |
    | expects @string
    |
    */
    'route_name_prefix' => 'admin.',
    'route_path_prefix' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Exempted routes
    |--------------------------------------------------------------------------
    |
    | This option defines routes that may be within the protected prefix but should not be
    | protected. 
    |
    | expects @array of strings, eg ['dashboard']
    |
    */
    'except' => [
        'dashboard',
        'profile.show'
    ],

    /*
    |--------------------------------------------------------------------------
    | Controller Namespace
    |--------------------------------------------------------------------------
    |
    | This option defines the namespace to which the UserPermissionsController and RolePermissionsController lies  under the
    | controllers directory.
    |
    | expects @string
    |
    */
    'controller_namespace' => 'App\Http\Controllers\Admin',
];