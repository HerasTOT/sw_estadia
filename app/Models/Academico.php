<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academico extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'matricula',
        'grado',
        'grupo',
        'tutor',
        'periodo',
        'materia_recursar',
        'status',
        'version',
        'formato',
       ];

       
}
