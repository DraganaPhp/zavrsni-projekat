<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';
    protected $fillable = [
        'blog_post_category_id', 'subject', 'description',
        ];
    
    public function blogPostCategory() {

        return $this->belongsTo(
        BlogPostCategory::class,
                        'blog_post_category_id',
                        'id',
        );
    }
    
    public function tags() {
        return $this->belongsToMany(
                        Tag::class,
                        'blog_post_tags',
                        'blog_post_id',
                        'tag_id'
        );
    }
}
