<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AperAssessment extends Model
{
    protected $fillable=['aper_measurement_period_id','employee_id','manager_id','manager_approved','employee_approved','manager_approved_date','employee_approved_date','created_by','updated_by','company_id','manager_comment','employee_comment','score'];
    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }
    public function measurement_period()
    {
        return $this->belongsTo('App\AperMeasurementPeriod', 'aper_measurement_period_id');
    }
    public function manager()
    {
        return $this->belongsTo('App\User', 'manager_id');
    }
    public function author()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function modifier()
    {
        return $this->belongsTo('App\User','updated_by');
    }
    public function assessment_details()
    {
        return $this->hasMany('App\AperAssessmentDetail', 'aper_assessment_id');
    }

}
