<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communicate extends Model
{
    use HasFactory;

    protected $fillable  = ['phone', 'budget', 'budget_from_org', 'budget_out_of_org', 'notes', 'family_id', 'isCom', 'status'];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
