<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// العلاج الطبي
class MedicalTreatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'status',
        'provider',
        'family_member_id',
        'notes',
		'budget',
        'budget_from_org', 
        'budget_out_of_org'
    ];

    public function familyMember() {
        return $this->belongsTo(FamilyMember::class);
    }
}
