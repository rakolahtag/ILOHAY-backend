<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stagiaire extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'email',
        'nom',
        'prenom',
        'telephone',
        'genre',
        'cin',
    ];
}
