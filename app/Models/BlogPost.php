<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model {

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const INDEX_IMPORTANT = 1;
    const INDEX_UNIMPORTANT = 0;

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

    public function comments() {
        return $this->hasMany(
                        Comment::class,
                        'blog_post_id',
                        'id'
        );
    }

    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

    public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/blog_posts/' . $this->photo);
        }
        return url('/themes/front/img/blog-1.jpg');
    }

    public function getPhotoThumbUrl() {
        if ($this->photo) {
            return url('/storage/blog_posts/thumbs/' . $this->photo);
        }


        return url('/themes/front/img/blog-post-1.jpeg');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this; //fluent interface
        }

        $photoFilePath = public_path('/storage/blog_posts/' . $this->photo);

        if (!is_file($photoFilePath)) {
            //informacija o fajlu postoji u bazi
            //ali fajl e postoji fizicki na Hard Disku
            return $this;
        }

        unlink($photoFilePath);

        //brisanje thumb verzije

        $photoThumbPath = public_path('/storage/blog_posts/thumbs/' . $this->photo);

        if (!is_file($photoThumbPath)) {
            //thumb slika ne postoji na disku
            return $this;
        }

        unlink($photoThumbPath);

        return $this;
    }

}
