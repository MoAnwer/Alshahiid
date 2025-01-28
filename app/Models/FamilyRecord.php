<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyRecord extends Model
{
    use HasFactory;

    protected $faillable = ['martyrdom_confrmination', 'illam_sharaii', 'factorization'];
}
