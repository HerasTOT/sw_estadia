<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;

    protected $fillable = ['date_start', 'date_end', 'id_announcements', 'id_events', 'observations'];

    public function announcements()
    {
        return $this->hasOne(announcements::class, 'id', 'id_announcements');
    }

    public function events()
    {
        return $this->hasOne(events::class, 'id', 'id_events');
    }
}
