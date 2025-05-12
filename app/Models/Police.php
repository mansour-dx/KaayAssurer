<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Police extends Model
{
    use HasFactory;
    
    // Ajoutez cette ligne pour spécifier le nom correct de la table
    protected $table = 'polices';
    
    // Le reste de votre code de modèle...
}
