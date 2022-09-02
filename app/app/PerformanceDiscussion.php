<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceDiscussion extends Model
{
    //
    protected $fillable = ['evaluation_id','title','discussion'];

    public function bscevaluation(){
        return $this->belongsTo('App\BscEvaluation','evaluation_id')->withDefault();
    }
}
