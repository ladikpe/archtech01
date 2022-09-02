<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperMetric extends Model
{
   protected $fillable=['name','created_by','updated_by','fillable'];
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function sub_metrics(){
        return $this->hasMany('App\AperSubMetric', 'aper_metric_id');
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
