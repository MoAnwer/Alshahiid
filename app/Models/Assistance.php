<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'status',
        'budget',
        'notes',
        'family_id',
        'budget_from_org', 
        'budget_out_of_org'
    ];

    public function family() {
        return $this->belongsTo(Family::class);
    }
}
