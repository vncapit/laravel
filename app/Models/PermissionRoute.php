<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

/**
 * App\Models\PermissionRoute
 *
 * @property int $id
 * @property int $permission_id
 * @property int $route_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute whereRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRoute whereUpdatedAt($value)
 * @property-read Permission|null $permission
 * @mixin \Eloquent
 */
class PermissionRoute extends Model
{
    use HasFactory;
    protected $table = 'permission_route';

    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
}
