<?php

namespace App\Http\Middleware;

use App\Modules\Permission\PermissionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasPermissions;

class CheckPermission
{
    use HasPermissions;
    const bypassRoutes = [
        'auth.login',
        'auth.logout'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();
        if (in_array($routeName, self::bypassRoutes)) {
            return $next($request);
        }

        $shouldHasPermission = app(PermissionService::class)->findPermissionForRoute($routeName);
        \Log::info('should', [$routeName, $shouldHasPermission]);

        foreach ($shouldHasPermission as $permission) {
            $res = api_user_model()->hasPermissionTo($permission, 'api');
            if ($res) {
                return $next($request);
            }
        }
        throw new UnauthorizedException('402');
    }


}
