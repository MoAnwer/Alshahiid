<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeService extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'budget', 'family_id', 'notes', 'manager_name', 'provider', 'budget_from_org', 'budget_out_of_org', 'status'];

    public function family() {
        return $this->belongsTo(Family::class);
    }
}
