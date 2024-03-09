<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_id',
        'eleve_id',
        'matiere_id',
        'justifiee',
        'promotion_id'
    ];

    /**
     * Obtient l'élève associé à l'absence.
     */
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }


    /**
     * Obtient la matière associée à l'absence.
     */
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
