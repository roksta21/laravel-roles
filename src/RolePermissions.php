<?php

namespace Roksta\Permit;

use Illuminate\Http\Request;
use Roksta\Permit\Models\RolePermission;
use Auth;
use DB;

trait RolePermissions
{
	public function index()
	{
		$roles = RolePermission::get();

		return view('vendor.roksta.permissions.roles.index')->withRoles($roles);
	}

	public function create()
	{
		$permissions = DB::table('all_permissions')->get();

		return view('vendor.roksta.permissions.roles.create')->withPermissions($permissions);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'permissions' => 'required'
		]);

		$role = RolePermission::create([
			'name' => $request->name,
			'permissions' => json_encode($request->permissions)
		]);

		return redirect()->route(config('permissions.route_name_prefix').'permissions.roles.show', $role->id);
	}

	public function show($id)
	{
		$role = RolePermission::findOrFail($id);

		return view('vendor.roksta.permissions.roles.show')->withRole($role);
	}

	public function edit($id)
	{
		$role = RolePermission::findOrFail($id);
		$permissions = DB::table('all_permissions')->get();

		return view('vendor.roksta.permissions.roles.edit')->withRole($role)->withPermissions($permissions);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'permissions' => 'required'
		]);

		$role = RolePermission::findOrFail($id);
		$role->update([
			'name' => $request->name,
			'permissions' => json_encode($request->permissions)
		]);

		return redirect()->route(config('permissions.route_name_prefix').'permissions.roles.show', $role->id);
	}

	public function destroy($id)
	{
		RolePermission::findOrFail($id)->delete();

		return redirect()->route(config('permissions.route_name_prefix').'permissions.roles.index');
	}
}