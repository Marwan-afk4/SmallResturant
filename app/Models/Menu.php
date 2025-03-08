<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{


    protected $fillable = [
        'resturant_id',
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'status',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function resturant(){
        return $this->belongsTo(Resturant::class);
    }
}
