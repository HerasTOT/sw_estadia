<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description' ,'num_announcement', 'y_announcement', 'status', 'institutions_id'];


    public function calendars(){
        return $this->hasMany(calendar_announcement::class);
    }

    public function institutions()
    {
        return $this->belongsTo(institutions::class, 'institutions_id');
    }

    public function documents_supporting()
    {
        $table = 'announcement_document_supporting';
        return $this->belongsToMany(Document_Supporting::class, $table, 'announcements_id', 'document_supporting_id');
    }

    

    public function assesstment_criterias()
    {
        $table = 'announcement_assesstment_criteria';
        return $this->belongsToMany(Assestment_Criteria::class, $table, 'announcements_id', 'assessment_criteria_id');
    }

    
}
