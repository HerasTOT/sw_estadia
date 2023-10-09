<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renapo extends Model
{
    use HasFactory;
    protected $table = 'renapohistory';

    protected $fillable = [
        'curp',
        'nombres',
        'apellidoPaterno',
        'apellidoMaterno'
    ];
}
