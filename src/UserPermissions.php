<?php

namespace Roksta\Permit;

use Illuminate\Http\Request;
use Roksta\Permit\Models\RolePermission;
use DB;

trait UserPermissions
{
    public function index()
    {
    	$users = config('auth.providers')['users']['model']::get(['id', 'name']);

    	return view('vendor.roksta.permissions.users.index')->withUsers($users);
    }

    public function show($id)
    {
    	$user = config('auth.providers')['users']['model']::findOrFail($id);

    	return view('vendor.roksta.permissions.users.show')->withUser($user);
    }

    public function edit($id)
    {
    	$user = config('auth.providers')['users']['model']::findOrFail($id);
    	$permissions = DB::table('all_permissions')->get();
        $roles = RolePermission::get(['id', 'name']);

    	return view('vendor.roksta.permissions.users.edit')->withUser($user)
    		->withPermissions($permissions)
            ->withRoles($roles);
    }

    public function update(Request $request, $id)
    {
    	$user = config('auth.providers')['users']['model']::findOrFail($id);
        if ($request->role_id == 0) {
        	$request->validate([
        		'permissions' => 'required'
        	]);

            if($user->userPermissions) {
                $user->userPermissions()->update([
                    'permissions' => json_encode($request->permissions)
                ]);
            } else {
                $user->userPermissions()->create([
                    'permissions' => json_encode($request->permissions)
                ]);
            }
        } else {
            $role = RolePermission::findOrFail($request->role_id);

            if($user->userPermissions) {
                $user->userPermissions()->update([
                    'permissions' => $role->permissions()->toJson()
                ]);
            } else {
                $user->userPermissions()->create([
                    'permissions' => $role->permissions()->toJson()
                ]);
            }
        }

    	return redirect()->route(config('permissions.route_name_prefix').'permissions.users.show', $id);
    }
}
