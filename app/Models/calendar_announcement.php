<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calendar_announcement extends Model
{
    use HasFactory;

    protected $fillable = ['date_start', 'date_end', 'announcements_id', 'name'];

    public function announcements()
    {
        return $this->belongsTo(Announcements::class, 'announcements_id');
    }
}
