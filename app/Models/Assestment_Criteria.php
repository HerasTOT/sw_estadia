<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assestment_Criteria extends Model
{
    use HasFactory;

    protected $table = 'assestment_criterias';

    protected $fillable = ['name', 'value'];

}
