<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{


    protected $fillable = [
        'resturant_id',
        'number',
        'status',
    ];

    public function resturant(){
        return $this->belongsTo(Resturant::class);
    }
}
