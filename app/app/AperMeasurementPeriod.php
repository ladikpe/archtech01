<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperMeasurementPeriod extends Model
{

    protected $fillable=['from','to','created_by','updated_by'];

    public function assessments()
    {
        return $this->hasMany('App\AperAssessment', 'aper_measurement_period_id');
    }
    public function author()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function modifier()
    {
        return $this->belongsTo('App\User','updated_by');
    }
}
