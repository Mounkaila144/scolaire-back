<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scolarite extends Model
{
    use HasFactory;

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
  public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    protected $fillable = [
        'prix',
        'eleve_id',
        'promotion_id'
    ];
}
