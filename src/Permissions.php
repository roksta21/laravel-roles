<?php

namespace Roksta\Permit;

use Roksta\Permit\Models\Permission;

trait Permissions
{
	public function permissions()
    {
        $permissions = $this->userPermissions ? json_decode($this->userPermissions->permissions) : [];

        return collect($permissions);
    }

    public function userPermissions()
    {
    	return $this->hasOne(Permission::class);
    }

    public function sees($route)
    {
    	return $this->permissions()->contains($route);
    }
}