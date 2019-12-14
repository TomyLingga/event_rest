<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];


    public function tickets()
    {
        return $this->hasMany('App\Ticket', 'eid');     // 1 event punya banyak tiket
    }
}
