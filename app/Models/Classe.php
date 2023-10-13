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
    protected $fillable = [
        'nom',
        'prix'
    ];
}
