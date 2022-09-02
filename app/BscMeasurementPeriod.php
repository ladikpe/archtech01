<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BscMeasurementPeriod extends Model
{
    protected $table="bsc_measurement_periods";
   protected $fillable=['from','to'];

   public function evaluations()
    {
        return $this->hasMany('App\BscEvaluation', 'bsc_measurement_period_id');
    }
}
