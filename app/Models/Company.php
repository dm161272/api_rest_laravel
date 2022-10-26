<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'website',
        'name',
        'founded',
        'size',
        'locality',
        'region',
        'country',
        'industry',
        'linkedin_url',
    ];
  
    protected $primaryKey = 'id';
}
