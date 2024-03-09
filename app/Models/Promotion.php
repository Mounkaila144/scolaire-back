<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{

    use HasFactory;

    public function depense()
    {
        return $this->belongsTo(Depense::class);
    }

    public function scolarite()
    {
        return $this->hasOne(Scolarite::class);
    }

    public function payteacher()
    {
        return $this->hasOne(Payteacher::class);
    }

    public function eleves()
    {
        return $this->belongsToMany(Eleve::class);
    }



    protected $fillable = [
        'debut',
        'fin'
    ];
}
