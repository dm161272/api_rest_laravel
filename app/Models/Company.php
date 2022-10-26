<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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


    // Display companies' listing ordered by size - ascending or descending.
    public function indexBySize($order)
    {
     return $this->orderBy('size', $order)->get();
    }

   
}
