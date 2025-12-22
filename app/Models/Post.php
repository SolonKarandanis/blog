<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $image
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string|null $published_at
 * @property int $is_published
 * @property int $is_featured
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @property-read \App\Models\User $author
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $likes
 * @property-read int|null $likes_count
 * @property-read mixed $published_at_diff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withCategory(string $category)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withoutTrashed()
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaTitle($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Video> $videos
 * @property-read int|null $videos_count
 * @mixin \Eloquent
 */
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes;

    protected $appends=['published_at_diff'];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'published_at',
        'featured',
        'meta_title',
        'meta_description',
        'is_featured'
    ];

    protected $casts=[
        'published_at'=>'datetime',
    ];

    public function author():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments():HasMany{
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'post_like', 'post_id', 'user_id')
            ->withTimestamps();
    }

    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'post_video', 'video_id', 'post_id')
            ->withTimestamps();
    }

    public function scopePublished($query){
        return $query->where('is_published',1);
    }

    public function scopeFeatured($query){
        return $query->where('is_featured',1);
    }

    public function scopeWithCategory($query, string $category){
        if($category){
            return $query->whereHas('categories',function($query) use($category){
                $query->where('slug',$category);
            });
        }
        return $query;
    }

    public function publishedAtDiff(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->published_at) {
                    return $this->published_at->diffForHumans();
                }

                return null;
            }
        );
    }

    public function getExcerpt(): string
    {
        return Str::limit(strip_tags($this->body),100);
    }

    public function getReadingTime(): float
    {
        $mins= round(str_word_count($this->body)/250);
        return ($mins < 1)? 1 : $mins;
    }

    public function getThumbnailImage():string
    {
        $isUrl=str_contains($this->image,'http');
        return ($isUrl) ? $this->image : Storage::disk('public')->url($this->image);
    }
}
