<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\PermissionRoute;
use App\Models\Route;
use App\Models\User;
use App\Modules\Permission\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function getAllRoute()
    {
        $enableRoutes = Route::all()->pluck('name')->toArray();
        $allRoutes = \Illuminate\Support\Facades\Route::getRoutes()->getIterator();
        $allRoutes = collect($allRoutes)->where('action.prefix','=', 'api/v1')->pluck('action.as')->toArray();
        $disableRoute = array_values(array_diff($allRoutes, $enableRoutes));

        $data = [
            'enableRoute' => $enableRoutes,
            'disableRoute' => $disableRoute,
            'allRoute' => $allRoutes
        ];

        return $this->success($data);
    }

    public function disableRoutes(Request $request)
    {
        $this->validate($request, [
            'routes' => 'required|array',
        ]);
        $routes = $request->routes;
        return $this->success(Route::whereIn('name', $routes)->delete()) ;
    }

    public function enableRoutes(Request $request)
    {
        $this->validate($request, [
            'routes' => 'required|array',
        ]);

        $routes = $request->routes;
        $allRoutes = \Illuminate\Support\Facades\Route::getRoutes()->getIterator();
        $allRoutes = collect($allRoutes)->where('action.prefix','=', 'api/v1')->pluck('action.as')->toArray();
        $insertRoutes = array_intersect($routes, $allRoutes);

        try {
            foreach ($insertRoutes as $route){
                $checkRoute = Route::whereName($route)->first();
                if (!$checkRoute) {
                    $newRoute = new Route();
                    $newRoute->name = $route;
                    $newRoute->save();
                }
            }
            return $this->success(true);
        }
        catch (\Exception $e) {
            \Log::info('Enable route failed: ', [$e->getMessage()]);
            return $this->failed();
        }
    }

    public function getRoleInfo(Request $request)
    {
        if ($request->id) {
            return Role::with('permissions')->select()->where('id','=', $request->id)->paginate();
        }
        return $this->success(Role::with('permissions')->select()->paginate()) ;
    }

    public function createPermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:permissions,name',
            'guard_name' => 'required|string',
        ]);

        $res = new Permission();
        $res->name = $request->name;
        $res->guard_name = $request->guard_name;
        return $this->success($res->save());
    }

    public function editPermission(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|int|exists:permissions,id',
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::find($request->id);
        $permission->name = $request->name;
        return $this->success($permission->save());
    }

    public function permissionBindRoutes(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required|int|exists:permissions,id',
            'route_ids' => 'nullable|array|exists:routes,id',
        ]);

        $permission_id = $request->permission_id;
        $route_ids = $request->route_ids;

        PermissionRoute::where('permission_id', $permission_id)->delete();

        foreach ($route_ids as $route_id) {
            $permission_route = new PermissionRoute();
            $permission_route->permission_id = $permission_id;
            $permission_route->route_id = $route_id;
            $permission_route->save();
        }

        return $this->success(true);
    }

    public function createRole(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        return $this->success($role->save());
    }

    public function givePermissionToRole(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|int|exists:roles,id',
            'permission_ids' => 'required|exists:permissions,id'
        ]);

        $role = Role::findById($request->role_id, 'api');
        $role->givePermissionTo($request->permission_ids);
        return $this->success([
            'role' => $role,
            'permission' => $role->permissions()->get()
        ]);
    }

    public function assignRole(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|int|exists:roles,id',
            'user_id' => 'required|int|exists:users,id'
        ]);

        $user = User::find($request->user_id);
        $this->success($user->assignRole($request->role_id));

    }

}
