<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Profile extends Model
{
    protected $collection = 'profiles';
    protected $fillable = ['gender','phone','date_of_birth','user_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','_id');
    }
}
