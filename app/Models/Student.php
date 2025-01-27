<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['family_member_id', 'stage', 'class', 'school_name'];

    public function familyMember() 
    {
        return $this->belongsTo(FamilyMember::class);
    }

        
    public function educationServices()
    {
        return $this->hasMany(EducationService::class)->orderByDESC('id');
    }
}
