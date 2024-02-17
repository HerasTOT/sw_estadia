<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recursamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia',
        'periodo',
        'profesor',
        'horarios',
        ];
}
