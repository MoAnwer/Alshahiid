<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;


    protected $fillable = ['family_id', 'birth_date', 'name', 'age', 'gender', 'relation', 'personal_image', 'phone_number', 'national_number', 'health_insurance_number', 'health_insurance_start_date', 'health_insurance_end_date'];

    public function family() {
        return $this->belongsTo(Family::class);
    }
    
    public function medicalTreatment() {
        return $this->hasOne(MedicalTreatment::class);
    }

    public function medicalTreatments() {
        return $this->hasMany(MedicalTreatment::class)->orderByDESC('id');
    }

    public function student() {
        return $this->hasOne(Student::class);
    }

    public function marryAssistances() {
        return $this->hasMany(MarryAssistance::class)->orderByDESC('id');
    }

    public function documents() {
        return $this->hasMany(FamilyMemberDocument::class)->orderByDESC('id');
    }

    public function hags() {
        return $this->hasMany(Hag::class)->orderByDESC('id');
    }

    public static function boot() {

        parent::boot();

        static::deleting(function ($member) { 
            $member->documents()->delete();
            $member->student()->delete();
            $member->marryAssistances()->delete();
            $member->hags()->delete();
            $member->medicalTreatment()->delete();
            $member->medicalTreatment()->delete();
        });
    }

}
