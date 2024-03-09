<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payadmin extends Model
{
    use HasFactory;

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $fillable = [
        'prix',
        'user_id',
        'promotion_id'
    ];
}
