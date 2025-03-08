<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookedTable extends Model
{


    protected $fillable =[
        'available_table_id',
        'table_id',
        'user_id',
        'date',
        'guests',
        'time'
    ];

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function avalibleTable(){
        return $this->belongsTo(AvailableTable::class);
    }
}
