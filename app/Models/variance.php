<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variance extends Model
{
    use HasFactory;

    protected $fillable = ['variance_name'];  
  
    public function images()  
    {  
        return $this->hasMany(VarianceImages::class);  
    } 

}
