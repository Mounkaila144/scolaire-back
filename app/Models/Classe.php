<?php

namespace App\Models;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }
public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }


    protected $fillable = [
        'nom',
        'prix',
        'promotion_id'
    ];
}
