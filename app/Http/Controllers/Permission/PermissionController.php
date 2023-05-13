<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Modules\Permission\PermissionService;
use Illuminate\Http\Request;
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

        return [
            'enableRoute' => $enableRoutes,
            'disableRoute' => $disableRoute,
            'allRoute' => $allRoutes
        ];
    }

    public function disableRoutes(Request $request)
    {
        $this->validate($request, [
            'routes' => 'required|array',
        ]);
        $routes = $request->routes;
        return Route::whereIn('name', $routes)->delete();
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
            return true;
        }
        catch (\Exception $e) {
            \Log::info('Enable route failed: ', [$e->getMessage()]);
            return -1;
        }
    }

    public function getRoleInfo(Request $request)
    {
        if ($request->id) {
            return Role::with('permissions')->select()->where('id','=', $request->id)->paginate();
        }
        return Role::with('permissions')->select()->paginate();
    }


}
