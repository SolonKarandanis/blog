<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $post_id
 * @property int|null $user_id
 * @property string $ip_address
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostView whereUserId($value)
 * @mixin \Eloquent
 */
class PostView extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'ip_address',
        'user_agent',
    ];
}
