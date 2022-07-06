<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'body',
    ];

    public function images()
    {
        $this->hasMany(PostImage::class);
    }

    public function links()
    {
        $this->hasMany(PostLink::class);
    }
}
