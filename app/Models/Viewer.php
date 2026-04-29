<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Viewer extends Model
{
    protected $collection = 'viewers';
    protected $fillable = ['rating','comment','product_id','creator'];
}
