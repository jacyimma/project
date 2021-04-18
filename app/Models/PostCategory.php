<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    public function user_posts()
    {
        return $this->belongsToMany(UserPosts::class,'post_category_pivots', 'category_id', 'post_id');
    }
}
