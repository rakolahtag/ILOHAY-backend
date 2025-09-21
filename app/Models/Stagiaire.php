<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'etablissement',
        'niveau_en_classe',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
