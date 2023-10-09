<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proposals_user extends Model
{
    use HasFactory;

    protected $table = 'proposals_user';
    
    protected $fillable = [
        'proposals_id',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function proposals()
    {
        return $this->belongsTo(Proposals::class, 'proposals_id');
    }
}
