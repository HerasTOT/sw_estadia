<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class announcement_assestment_criteria extends Model
{
    use HasFactory;

    protected $table = 'announcement_assesstment_criteria';

    protected $fillable = ['id_announcements', 'id_assestment_criteria'];

    public function announcements(){
        return $this->belongsTo(Announcements::class,'id_announcements');
    }

    public function assestment_criteria(){
        return $this->belongsTo(Assestment_Criteria::class,'id_assestment_criteria');
    }
}
