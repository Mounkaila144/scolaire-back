<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    protected $fillable = [
        'details',
        'prix',
        'promotion_id'
    ];
}
