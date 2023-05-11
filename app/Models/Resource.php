<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Resource
 *
 * @property int $id
 * @property string $resourceable_type
 * @property int $resourceable_id
 * @property string $name
 * @property string $path
 * @property string $extension
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $resourceable
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereResourceableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereResourceableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereUpdatedAt($value)
 * @property string $md5
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereMd5($value)
 * @mixin \Eloquent
 */
class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';

    public function resourceable()
    {
        return $this->morphTo();
    }
}
