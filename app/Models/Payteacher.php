<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payteacher extends Model
{
    use HasFactory;

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }


    protected $fillable = [
        'prix',
        'professeur_id',
        'promotion_id'
    ];
}
