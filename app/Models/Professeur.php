<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $fillable = [
        'number',
        'adresse',
        'birth',
        'nationalite',
        'genre',
        'user_id'
    ];
}
