<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Brand extends Model
{
    protected $collection = 'brands';
    protected $fillable = ["name","country","logo","logo_url","logo_public_id","status","description","creator"];

    public function product(){
        return $this->hasMany(Product::class,'brand_id','_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'creator',"_id");
    }
}
