<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationService extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'status', 'budget', 'budget_from_org', 'budget_out_of_org', 'student_id', 'notes'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
