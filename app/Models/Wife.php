<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wife extends Model
{
    use HasFactory;

    protected $fillable = ['martyr_id', 'name', 'bank_account'];

    public function martyr() 
    {
        return $this->belongsTo(Martyr::class);
    }
}
