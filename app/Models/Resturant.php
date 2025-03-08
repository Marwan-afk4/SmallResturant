<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{


    protected $fillable = [
        'name',
        'location',
        'phone',
        'email',
    ];

    public function menus(){
        return $this->hasMany(Menu::class);
    }

    public function tables(){
        return $this->hasMany(Table::class);
    }
}
