<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'storage_path', 'family_id', 'notes'];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
