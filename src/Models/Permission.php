<?php

namespace Roksta\Permit\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
    	'user_id', 'permissions'
    ];

}
