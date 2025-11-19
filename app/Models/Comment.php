<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUserId($value)
 * @property-read mixed $created_at_diff
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @property int|null $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereParentId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'body',
        'parent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function parentComment():BelongsTo{
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function childrenComments():HasMany{
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'desc');
    }

    public function createdAtDiff():Attribute
    {
        return Attribute::make(
            get:fn()=> $this->created_at->diffForHumans()
        );
    }
}
