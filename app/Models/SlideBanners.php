<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SlideBanners extends Model
{
    protected $fillable = [
        'title',
        'desc',
        'banner_image',
        'banner_image_url',
        'banner_image_public_id',
        'creator'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'creator');
    }
}
