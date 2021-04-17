<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPosts extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'slug', 'image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
