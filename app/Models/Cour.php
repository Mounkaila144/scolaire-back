<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    use HasFactory;

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
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
        'schedule_id',
        'professeur_id',
        'promotion_id'
    ];
}
