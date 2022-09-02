<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperPerformanceDiscussion extends Model
{
    protected $fillable = ['aper_assessment_id','title','discussion','created_by'];

    public function assessment(){
        return $this->belongsTo('App\BscEvaluation','evaluation_id')->withDefault();
    }
    public function creator(){
        return $this->belongsTo('App\User','created_by')->withDefault();
    }
}
