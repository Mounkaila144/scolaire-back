<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }


    protected $fillable = [
        'jour',
        'debut',
        'classe_id',
        'matiere_id',
        'professeur_id',
        'promotion_id'
    ];
}
