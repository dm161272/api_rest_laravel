<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dice extends Model
{
  
    public static function throw() {
        return rand(1, 6);
    }
}
