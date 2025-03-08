<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableTable extends Model
{


    protected $fillable = [
        'resturant_id',
        'table_id',
        'date',
        'time_from',
        'time_to',
        'status'
    ];

    public function resturant(){
        return $this->belongsTo(Resturant::class);
    }

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function bookedTable(){
        return $this->hasMany(BookedTable::class);
    }
}
