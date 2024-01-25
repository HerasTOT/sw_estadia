<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $fillable = [
        'grado_academico',
        'area',
        'user_id'
       ];
       public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
