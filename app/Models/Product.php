<?php

namespace App\Models;

use App\Traits\HasSkuAndBarcode;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    use HasSkuAndBarcode;

    protected $collection = 'products';
    protected $fillable = [
        'name',
        'price',
        'cost_price',
        'discount',
        'stock',
        'status',
        'sku',
        'barcode',
        'tags',
        'rating',
        'review_count',
        'description',
        'image',
        'image_url',
        'image_public_id',
        'brand_id',
        'creator',
        'category_id'
    ];
    
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'creator','_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','_id');
    }
    public function productDetail(){
        return $this->hasOne(ProductDetail::class,'product_id','_id');
    }
}
