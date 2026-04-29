<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $collection = 'categories';
    protected $fillable = ['name','status','description','color','creator'];

    public function user(){
        return $this->belongsTo(User::class,"creator","_id");
    }
    public function product(){
        return $this->hasMany(Product::class, "category_id","_id");
    }
}
