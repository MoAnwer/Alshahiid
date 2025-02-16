<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'date', 'budget', 'budget_from_org', 'budget_out_of_org', 'notes', 'sector', 'locality'];
}
