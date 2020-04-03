<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

   public function getPhotoUrl() {
        if ($this->photo) {
            return url('/storage/users/' . $this->photo);
        }
        return url('/themes/front/img/products/products-01.jpg');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this; //fluent interface
        }

        $photoFilePath = public_path('/storage/users/' . $this->photo);

        if (!is_file($photoFilePath)) {
//informacija o fajlu postoji u bazi
//ali fajl e postoji fizicki na Hard Disku
            return $this;
        }

        unlink($photoFilePath);
        return $this;
    }
}

