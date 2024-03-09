<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
    public function textes()
    {
        return $this->hasMany(Texte::class);
    }
    public function cours()
    {
        return $this->hasMany(Cour::class);
    }

    protected $fillable = [
        'nom',
        'coef',
        'classe_id',
        'professeur_id',
        'promotion_id'
    ];
}
