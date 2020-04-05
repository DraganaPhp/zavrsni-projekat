<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['name'];
    
    public function products() {
        return $this->belongsToMany(
                        BlogPost::class,
                        'blog_post_tag',
                        'tag_id',
                        'blog_post_id',
        );
    }
}
