<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }

    public function words()
    {
        return $this->hasMany('App\Models\Word');
    }
}
