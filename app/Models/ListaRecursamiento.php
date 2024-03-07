<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaRecursamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'recursamiento_id',
       ];
}
