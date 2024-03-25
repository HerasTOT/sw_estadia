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
        'profesor_id',
        'periodo_id',
        'materia_recursar',
        'estatus',
        'version',
        'formato',
       ];

       public function profesor()
    {
        return $this->hasMany(Profesor::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
