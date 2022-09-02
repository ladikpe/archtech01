<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable=['user_id','visitor_id','name','email','phone','date','time','gender','purpose_id','initiated_by','code','description','status','signature','passport'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function visitor(){
        return $this->belongsTo('App\Visitor');
    }
    public function logs(){
        return $this->hasMany('App\VisitLog');
    }
    public function purpose(){
        return $this->belongsTo('App\VisitPurpose');
    }

    public function GetFormattedDateAttribute(){
        return Carbon::parse($this->date)->format('D,d M Y');
    }
    public function GetFormattedTimeAttribute(){
        return Carbon::parse($this->time)->format('h:i A');
    }
    protected $appends=['formatted_date','formatted_time'];
}