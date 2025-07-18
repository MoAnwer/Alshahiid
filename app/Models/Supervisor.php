<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone'];

    public function families() {
        return $this->hasMany(Family::class);
    }
}
