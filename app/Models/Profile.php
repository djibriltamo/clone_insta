<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'url', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImage()
    {
        $imagePath = $this->image ?? 'avatars/default.png';

        return "/storage/" . $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
