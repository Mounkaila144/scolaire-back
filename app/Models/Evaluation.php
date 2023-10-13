<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    protected $fillable = [
        'note',
        'sur',
        'type',
        'matiere_id',
        'eleve_id'
    ];
}
