<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SlideBanners extends Model
{
    protected $fillable = [
        'title',
        'desc',
        'image',
        'creator'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'creator');
    }
}
