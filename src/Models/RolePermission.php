<?php

namespace Roksta\Permit\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
    	'name', 'permissions'
    ];

    public function permissions()
    {
    	$permissions = $this->permissions ? json_decode($this->permissions) : [];

    	return collect($permissions);
    }
}
