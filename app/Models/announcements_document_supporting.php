<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class announcements_document_supporting extends Model
{
    use HasFactory;

    protected $table = 'announcement_document_supporting';

    protected $fillable = ['id_announcements', 'id_document_supporting'];

    public function announcements(){
        return $this->belongsTo(Announcements::class,'id_announcements');
    }

    public function document_supporting(){
        return $this->belongsTo(document_supporting::class,'id_document_supporting');
    }

}
