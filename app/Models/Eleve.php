<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class);
    }

    public function scolarites()
    {
        return $this->hasMany(Scolarite::class);
    }


    protected $fillable = [
        'number',
        'adresse',
        'birth',
        'nationalite',
        'genre',
        'classe_id',
        'user_id'
    ];
}
