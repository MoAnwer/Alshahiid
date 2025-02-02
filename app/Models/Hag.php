<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hag extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'status', 'budget', 'budget_from_org', 'budget_out_of_org', 'family_member_id'];

    public function familyMember() 
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
