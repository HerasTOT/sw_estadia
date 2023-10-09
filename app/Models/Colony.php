<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colony extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'postal_code',
        'township_id'
    ];

    public function township(){
        return $this->belongsTo(Township::class);
    }
}
