<?php

namespace App\Models;

use App\User;
use App\Models\BlogPostCategory;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model {

    const INDEX_ENABLED = 1;
    const INDEX_DISABLED = 0;

    protected $table = 'slides';
    protected $fillable = [
        'subject', 'link_title', 'link_url', 'photo'
    ];

    public function isEnabled() {
        return $this->on_index_page == self::INDEX_ENABLED;
    }

    public function isDisabled() {
        return $this->on_index_page == self::INDEX_DISABLED;
    }

    public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/slides/' . $this->photo);
        }
        return url('/themes/front/img/gallery-1.jpg');
    }

    public function getPhotoThumbUrl() {
        if ($this->photo) {
            return url('/storage/slides/thumbs/' . $this->photo);
        }


        return url('/themes/front/img/small-thumbnail-1.jpg');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this; //fluent interface
        }

        $photoFilePath = public_path('/storage/slides/' . $this->photo);

        if (!is_file($photoFilePath)) {
            //informacija o fajlu postoji u bazi
            //ali fajl e postoji fizicki na Hard Disku
            return $this;
        }

        unlink($photoFilePath);

        //brisanje thumb verzije

        $photoThumbPath = public_path('/storage/slides/thumbs/' . $this->photo);

        if (!is_file($photoThumbPath)) {
            //thumb slika ne postoji na disku
            return $this;
        }

        unlink($photoThumbPath);

        return $this;
    }

}
