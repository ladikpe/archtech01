<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperSubMetric extends Model
{
    protected $fillable=['name','created_by','updated_by','aper_metric_id','editable','user_id'];
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function metric()
    {
        return $this->belongsTo('App\AperMetric', 'aper_metric_id');
    }
    public function assessment_details()
    {
        return $this->hasMany('App\AperAssessmentDetail', 'aper_sub_metric_id');
    }

}
