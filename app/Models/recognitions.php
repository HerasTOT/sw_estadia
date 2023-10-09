<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recognitions extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'code',
        'proposal_id',
        'announcements_id',
        'user_id',
    ];
}
