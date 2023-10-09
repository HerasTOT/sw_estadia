<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterias extends Model
{
    use HasFactory;

    protected $fillable = [
        "assessment_criteria_id",
        "proposal_id",
        "observations",
        "user_id"
    ];

    public function proposals()
    {
        return $this->belongsTo(Proposals::class, 'proposal_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function assesstment_criterias()
    {
        return $this->belongsTo(Assestment_Criteria::class, 'assessment_criteria_id');
    }

}
