<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperAssessmentDetail extends Model
{
    protected $fillable = ['user_id','aper_assessment_id','aper_sub_metric_id','created_by','updated_by','score'];
    public function author()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function modifier()
    {
        return $this->belongsTo('App\User','updated_by');
    }
    public function sub_metric()
    {
        return $this->belongsTo('App\AperSubMetric','aper_sub_metric_id');
    }
    public function assessment()
    {
        return $this->belongsTo('App\AperAssessment','aper_assessment_id');
    }
}
