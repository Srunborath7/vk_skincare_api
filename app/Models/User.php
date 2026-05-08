<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function profile(){
        return $this->hasOne(Profile::class, 'user_id', '_id');
    }
    public function category(){
        return $this->hasMany(Category::class,"creator","_id");
    }
    public function brand(){
        return $this->hasMany(Brand::class,"creator","_id");
    }
    public function product(){
        return $this->hasMany(Product::class, "creator", "_id");
    }
    public function productDetail(){
        return $this->hasMany(ProductDetail::class, "creator", "_id");
    }
    public function slideBanner(){
        return $this->hasMany(SlideBanners::class, "creator", "_id");
    }
}
