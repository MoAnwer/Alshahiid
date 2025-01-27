<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['sector', 'locality', 'neighborhood', 'type', 'family_id'];

    public function family() {
        return $this->belongsTo(Family::class);
    }
}
