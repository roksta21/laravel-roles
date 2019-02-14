# Permissions Manager for laravel
This package provides a simple method for managing users on a system. It lists all of the available routes defined in your application and takes advantage of the route name to give each user permission to visit each route separately. That means that each user needs explicit permissions to access each route. The package comes with already built views for user and role management, so all you need to do is create a new user and you will be able to immediately fine tune their role.

## Installation
```bash
composer require roksta/laravel-roles
```

## Configuration
Migrate the database to create the tables needed by the package. 
```bash
php artisan migrate
```
Publish the config file
```bash
php artisan vendor:publish
```
and select the Roksta\Permit\PermissionsServiceProvider provider. This will create the permissions.php file within the config directory.

### Permissions.php
Set the appropriate settings as described in the commennts.
- super_admin_user_id is the user id to whom all the permissions are given to and has the right to set other user's permissions. This assumes the system already has a user in the user's table.
- route_name_prefix is the prefix of the name of the routes to protect. You must define your routes with a name and set a prefix.
- except arre the routes that may be prefixed by the route_name_prefix, eg, by grouping, but are not to be protected.

#### Example
routes/web.php
```php
Route::get('/', 'HomeController@home')->name('home');

Route::group(['as' => 'admin.'], function() {
	Route::get('profile', 'ProfileController@show')->name('profile.show');
	Route::resource('users', 'UsersController');
});
```
Listing the routes displays the named routes as
```bash
php artisan route:list
+------+---------+----------------+---------------------+---------------------------
|Domain|Method   |URI             | Name                | Action           
+------+---------+----------------+---------------------+--------------------------
|      | GET     |/               | home                |App\Http\Controlle     
|      | GET     |/profile        | admin.profile.show  |App\Http\Controlle     
|      | GET     |/users          | admin.users.index   |App\Http\Controlle       
|      | GET     |/users/create   | admin.users.create  |App\Http\Controlle     
|      | POST    |/users          | admin.users.store   |App\Http\Controlle       
|      | GET     |/users/{id}     | admin.users.show    |App\Http\Controlle        
|      | GET     |/users/{id}/edit| admin.users.edit    |App\Http\Controlle        
|      | PUT     |/users/{id}     | admin.users.update  |App\Http\Controlle        
|      | DELETE  |/users/{id}     | admin.users.destroy |App\Http\Controlle        
```
Config/permissions.php
```php
return [
	'super_admin_user_id' => 1,

	'route_name_prefix' => 'admin.',
	'route_path_prefix' => 'admin',

	'except' => [
		'profile.show',
		'users.index',
	],

	'controller_namespace' => 'App\Http\Controllers\Admin',
];
```

This means that
- '/' is not protected by any permissions as it does not fall within the 'admin.' route name prefix.
- Routes with names starting with 'admin.' will be protected. Users wishing to visit these routes will need to be granted permission or encounter a 403 error.
- '/profile' and '/users' will be exempted from these permissions and will be free to view.
- User with id 1 in the user's table will be given super admin permissions, meaning all rights to all routes. 
- controller_namespace defines the namespace where the controller UserPermissionsController resides.

Run
```bash
php artisan permissions:install
```
Returns
```bash
6 routes protected
Admin has been granted super admin permissions
```

Add ```php \Roksta\Permit\VerifyPermissions::class``` to your app\Http\Kernel.php in either $middlewareGroups or $routeMiddleware.

Create a controller in the controller_namespace called UserPermissionsController as below:
```php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Roksta\Permit\UserPermissions;

class UserPermissionsController extends Controller
{
    use UserPermissions;
}

```

Create a controller in the controller_namespace called RolePermissionsController as below:
```php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Roksta\Permit\RolePermissions;

class UserPermissionsController extends Controller
{
    use RolePermissions;
}

```

The above controllers are resource controllers that work out of the boox. However you may edit their functions here for a more tailored experience.

### Usage
The package comes with a few routes to enable user permissions and roles management. The route path prefix is used for the routes, eg, in our example, the registered routes by the package are 
```bash
+---------+----------------------------------+-------------------------------
|Method   |URI                               | Name                                     
+---------+----------------+---------------------+---------------------------
| GET     |/admin/permissions/users          | admin.permissions.users.index 
| GET     |/admin/permissions/users/{id}     | admin.permissions.users.show 
| GET     |/admin/permissions/users/{id}/edit| admin.permissions.users.edit 
| PUT     |/admin/permissions/users/{id}     | admin.permissions.users.update  

| GET     |/admin/permissions/roles          | admin.permissions.roles.index 
| GET     |/admin/permissions/roles/create   | admin.permissions.roles.create 
| POST    |/admin/permissions/roles/store    | admin.permissions.roles.store 
| GET     |/admin/permissions/roles/{id}     | admin.permissions.roles.show 
| GET     |/admin/permissions/roles/{id}/edit| admin.permissions.roles.edit 
| PUT     |/admin/permissions/roles/{id}     | admin.permissions.roles.update 
| DELETE  |/admin/permissions/roles/{id}     | admin.permissions.roles.destroy 
```

### Views
in your views, you may show or hide elements using the user model's sees() funtion, eg, in your links, you may choose to only show links that the user may follow to avoid unnecessary 403s. eg,

```html
@if(auth()->user()->sees('admin.users.create'))
<a href="{{ route('admin.users.create') }}">Create User</a>
@endif
```
Only users who have permission to create a user will see the link.

## Licence
This package is provided for open source use under the MIT Licence.