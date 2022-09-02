<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
    protected $fillable=['visit_id','status','date','message'];

    public function visit(){
        return $this->belongsTo('App\Visit');
    }
}
