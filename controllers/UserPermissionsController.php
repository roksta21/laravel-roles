<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Roksta\Permit\UserPermissions;

class UserPermissionsController extends Controller
{
    use UserPermissions; 
}
