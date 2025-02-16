<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    use HasFactory;

    protected $fillable  = ['budget', 'name', 'budget_out_of_org', 'budget_from_org', 'notes', 'status', 'start_at', 'end_at', 'sector', 'locality'];
}
