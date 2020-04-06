<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class Tag extends Model {

    protected $table = 'tags';
    protected $fillable = ['name'];

    public function blogPosts() {
        return $this->belongsToMany(
                        BlogPost::class,
                        'blog_post_tags',
                        'tag_id',
                        'blog_post_id',
        );
    }

}
