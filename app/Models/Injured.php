<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Injured extends Model
{
    use HasFactory;
	
	protected $fillable = ['name', 'type', 'injured_date', 'injured_percentage', 'notes', 'health_insurance_number', 'health_insurance_start_date', 'health_insurance_end_date'];
	
	public function injuredServices()
	{
		return $this->hasMany(InjuredService::class)->orderByDESC('id');
	}	
}
