<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalTotalReport extends Model
{
    use HasFactory;

    protected $fillable = ['need', 'done', 'budget', 'budget_from_org', 'budget_out_of_org', 'totalMoney', 'precentage'];
}
