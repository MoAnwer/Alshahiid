<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MartyrDoc extends Model
{
    use HasFactory;

    protected $fillable = ['budget', 'budget_from_org', 'budget_out_of_org', 'status', 'notes', 'storage_path'];

    public function martyr()
    {
        return $this->belongsTo(Martyr::class);
    }
}
