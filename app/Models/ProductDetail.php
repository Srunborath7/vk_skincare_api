<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ProductDetail extends Model
{
    protected $collection = 'product_details';
    protected $fillable = [
        'image_details',
        'skin_type',
        'product_type',
        'ingredients',
        'benefits',
        'usage',
        'volume_unit',
        'texture',
        'origin_country',
        'expiry_date',
        'manufacture_date',
        'product_id',
        'creator'
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id','_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'creator','_id');
    }
}
