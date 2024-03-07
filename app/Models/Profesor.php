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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function grupo()
    {
        return $this->hasOne(Grupo::class);
    }
    
}
