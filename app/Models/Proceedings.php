<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceedings extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'user_id',
        'proposal_id'
    ];

    public function proposal()
    {
        return $this->belongsTo(proposal::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'proposal_id');
    }
}
