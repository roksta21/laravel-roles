<?php

namespace Roksta\Permit\Commands;

use Illuminate\Console\Command;
use Route;
use DB;

class PermissionsCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the permissions in the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = config('auth.providers')['users']['model']::findOrFail(config('permissions.super_admin_user_id'));

        $routes = collect(Route::getRoutes()->get())->map(function($route) {
            return $route->getName();
        })->reject(function($route) {
            return $route == null;
        })->filter(function($route) {
            return starts_with($route, config('permissions.route_name_prefix'));
        })->reject(function($route) {
            return collect(config('permissions.except'))->map(function($val) {
                return config('permissions.route_name_prefix') . $val;
            })->contains($route);
        });

        DB::table('all_permissions')->truncate();

        $routes->each(function($route) {
            DB::table('all_permissions')->insert([
                'name' => $route
            ]);
        });

        $this->comment($routes->count() . ' routes protected');

        $user->userPermissions()->delete();

        $user->userPermissions()->create([
            'permissions' => $routes->toJson()
        ]);

        $this->comment($user->name . ' has been granted super admin permissions');
    }
}
