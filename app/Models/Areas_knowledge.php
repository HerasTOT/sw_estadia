<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas_knowledge extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => '1',
    ];

    protected $fillable = [ 'name', 'status'];

}
