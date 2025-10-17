<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function likes(){
        return $this->belongsToMany(User::class, 'post_like', 'post_id', 'user_id')
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

    public function publishedAtDiff():Attribute
    {
        return Attribute::make(
            get:fn()=> $this->published_at->diffForHumans()
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
