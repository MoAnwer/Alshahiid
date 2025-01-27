<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_type',
        'status',
        'budget',
        'manager_name',
        'provider',
        'notes',
        'family_id',
        'budget_from_org', 
        'budget_out_of_org',
        'monthly_budget',
        'expense',
        'work_status'
    ];

    public function family() {
        return $this->belongsTo(Family::class);
    }
}
