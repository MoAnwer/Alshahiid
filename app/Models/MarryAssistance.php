<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarryAssistance extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'budget', 'budget_from_org', 'budget_out_of_org', 'notes', 'family_member_id'];
    
    public function familyMember() {
        return $this->belongsTo(FamilyMember::class);
    }
}
