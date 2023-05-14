<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/13 11:35
 */

namespace App\Modules\Permission;


use App\Models\Route;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function __construct()
    {

    }

    /**
     * Notes: findPermissionForRoute
     * User: Cap
     * Date: 2023/05/14 14:54
     *
     * @param $route
     * @return mixed
     */
    public function findPermissionForRoute($route)
    {
        $route = Route::whereName($route)->first();
        if ($route) {
            $permissionIds = $route->permission_routes()->get()->pluck('permission_id')->toArray();
            return Permission::whereIn('id', $permissionIds)->get();
        }
        return [];
    }
}
