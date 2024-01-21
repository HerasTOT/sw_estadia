<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = [
        'grado',
        'grupo',
        'tutor',
        'materia',
        ];
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class);
    }
}
