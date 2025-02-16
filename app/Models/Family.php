<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'family_size', 'supervisor_id', 'martyr_id'];

    public function supervisor() {
        return $this->belongsTo(Supervisor::class);
    }

    public function martyr() {
        return $this->belongsTo(Martyr::class);
    }

    public function address() {
        return $this->hasOne(Address::class);
    }
	
	public function addresses() {
        return $this->hasMany(Address::class)->orderByDESC('created_at');
    }

    public function familyMembers() {
        return $this->hasMany(FamilyMember::class);
    }

    public function projects() {
        return $this->hasMany(Project::class)->orderBy('created_at', 'DESC');
    }

    public function homeService() {
        return $this->hasOne(HomeService::class)->orderBy('created_at', 'DESC');
    }

    public function homeServices() {
        return $this->hasMany(HomeService::class)->orderBy('created_at', 'DESC');
    }

    public function assistances() {
        return $this->hasMany(Assistance::class)->orderByDESC('created_at');
    }

    public function bails() {
        return $this->hasMany(Bail::class)->orderByDESC('created_at');
    }

    public function documents() {
        return $this->hasMany(Document::class)->orderByDESC('created_at');
    }

    public function communicate() {
        return $this->hasMany(Communicate::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(fn ($family) => $family->familyMembers()->delete());
    }

}
