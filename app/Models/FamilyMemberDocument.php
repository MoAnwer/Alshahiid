<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMemberDocument extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'storage_path', 'family_member_id', 'notes'];

    public function familyMember() 
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
