<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'image_name',
        'image_filter',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
