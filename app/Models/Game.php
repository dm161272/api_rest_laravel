<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['player_id', 'win', 'lose'];

    public static function game() {
        $throw_1 = Dice::throw();
        $throw_2 = Dice::throw();
        var_dump($throw_1, $throw_2);
        return (($throw_1 + $throw_2)%7) == 0;
}
}