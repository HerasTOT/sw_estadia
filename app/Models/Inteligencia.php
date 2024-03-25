<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inteligencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'matricula',
        'grado',
        'grupo',
        'profesor_id',
        'periodo_id',
        'formato',
        'version',
        'estatus'
      ];

      
}
