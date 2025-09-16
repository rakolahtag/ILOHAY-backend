<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    // Spécifiez les champs que vous pouvez remplir via une requête
    protected $fillable = [
        'email',
        'nom',
        'prenom',
        'telephone',
        'genre',
        'cin',
        'nationalite',
        'adresse',
        'paysOrigine',
    ];
}