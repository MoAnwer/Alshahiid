<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable  = ['budget', 'name', 'date', 'budget_out_of_org', 'budget_from_org', 'notes', 'status', 'sector', 'locality'];
}
