<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianceImages extends Model
{
    use HasFactory;

    protected $fillable = ['variance_id', 'image_path'];

    public function variance()
    {
        return $this->belongsTo(variance::class);
    }
}
