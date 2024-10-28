<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model 
{
    use HasFactory, Sortable;

    public function favorite_users(){
        return $this->belongsToMany(User::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

}
