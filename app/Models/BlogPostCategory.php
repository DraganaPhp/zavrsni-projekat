<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostCategory extends Model
{
   protected $table = 'blog_post_categories';
   
    protected $fillable = ['name', 'description','priority'];
    
    
    public function blog_posts() {
        return $this->hasMany(
                        BlogPost::class,
                        'blog_post_category_id',
                        'id'
        );
    }
}
