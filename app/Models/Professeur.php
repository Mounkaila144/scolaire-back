<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cour()
    {
        return $this->hasMany(Cour::class);
    }
    public function payteacher()
    {
        return $this->hasMany(Payteacher::class);
    }



    protected $fillable = [
        'number',
        'adresse',
        'birth',
        'nationalite',
        'genre',
        'user_id',

    ];
}
