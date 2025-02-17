<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const INDEX_IMPORTANT = 1;
    const INDEX_UNIMPORTANT = 0;

    protected $table = 'comments';
    protected $fillable = [
        'blog_post_id', 'sender_nickname', 'body', 'sender_email'
    ];

    public function blogPost() {

        return $this->belongsTo(
                        BlogPost::class,
                        'blog_post_id',
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
