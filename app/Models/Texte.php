<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Texte extends Model
{
    use HasFactory;

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    protected $fillable = [
        'texte',
        'matiere_id',
        'professeur_id',
        'promotion_id'
    ];
}
