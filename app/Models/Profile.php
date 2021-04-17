<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'phone',
        'about-me',
        'user_id'
    ];

    public function profile()
    {
        return $this->belongTo(User::class);
    }
}
