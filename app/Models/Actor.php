<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{

    public static $rules = array(
        'first_name' => 'required',
        'last_name'  => 'required',
        'birth_date' => 'required',
    );

    public function films()
    {
        return $this->belongsToMany('\\App\Models\\Film');
    }

    public function getFormattedBirthDateAttribute()
    {
        return date('Y-m-d', strtotime($this->getAttribute('birth_date')));
    }

    public function getNameAttribute()
    {
        return $this->getAttribute('first_name') . ' ' . $this->getAttribute('last_name');
    }
}
