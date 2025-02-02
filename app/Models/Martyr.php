<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Martyr extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'force',
        'unit',
        'record_date', 
        'record_number', 
        'martyrdom_date', 
        'martyrdom_place', 
        'rank', 
        'marital_status',
        'militarism_number',
        'rights'
    ];

    public function family() {
        return $this->hasOne(Family::class);
    } 

    public function martyrDoc() {
        return $this->hasOne(MartyrDoc::class);
    }

}
