<?php

namespace App\Models;

use App\User;
use App\Models\BlogPostCategory;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model {

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $table = 'blog_posts';
    protected $fillable = [
        'blog_post_category_id', 'subject', 'description', 'body', 'photo'
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

    public function user() {

        return $this->belongsTo(
                        User::class,
                        'user_id',
                        'id',
        );
    }

    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

}
