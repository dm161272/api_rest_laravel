<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dice extends Model
{
  
    public static function throw() {
        $number = rand(1, 6);
        return $number;
    }
}
