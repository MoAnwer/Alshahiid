<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InjuredService extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'name', 
		'status', 
		'type', 
		'description', 
		'budget', 
		'budget_from_org', 
		'budget_out_of_org', 
		'notes',
		'injured_id'
	];
	
	public function injured() 
	{
		return $this->belongsTo(Injured::class);
	}

	public function getBudgetFromOrgAttribute($value) {
		return $value == null ? 0: $value;
	}

	public function getBudgetOutOfOrgAttribute($value) {
		return $value == null ? 0: $value;
	}
}