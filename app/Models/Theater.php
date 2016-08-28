<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    public static $rules = [
        'name' => 'required',
    ];

    public function films()
    {
        return $this->belongsToMany('\\App\Models\\Film');
    }

    public function boxOffice()
    {
        return $this->hasMany('\\App\Models\\BoxOffice');
    }
}
