<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements HasMedia, JWTSubject
{
    use InteractsWithMedia, Notifiable;
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'phone', 'password', 'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function registerMediaCollections(Media $media = null): void {
        $this->addMediaCollection('avatar')->singleFile();
    }
}
