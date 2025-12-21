<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['path', 'title'];

    public function posts(){
        return $this->belongsToMany(Post::class, 'post_video', 'post_id', 'video_id')
            ->withTimestamps();
    }
}
