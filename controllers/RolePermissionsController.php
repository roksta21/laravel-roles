<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Roksta\Permit\RolePermissions;

class RolePermissionsController extends Controller
{
    use RolePermissions;
}
