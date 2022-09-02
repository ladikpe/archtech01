<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BehavioralEvaluationDetail extends Model
{
   protected $table="behaviour_evaluation_details";
    public $appends= ['modified_date','objective','measure','weighting','low_target','mid_target','upper_target'];
   protected $fillable=['bsc_evaluation_id','behavioral_sub_metric_id','actual','comment','crra','wcp'];
   public function behavioral_sub_metric()
    {
        return $this->belongsTo('App\BehavioralSubMetric', 'behavioral_sub_metric_id');
    }
    public function evaluation()
    {
        return $this->belongsTo('App\BscEvaluation', 'bsc_evaluation_id');
    }

    public function getModifiedDateAttribute(){
        return date('Y-m-d',strtotime($this->updated_at));
    }

    public function getObjectiveAttribute(){

        return $this->behavioral_sub_metric->objective;
    }
    public function getMeasureAttribute(){
        return $this->behavioral_sub_metric->measure;
    }
    public function getWeightingAttribute(){
        return $this->behavioral_sub_metric->weighting;
    }
    public function getLowTargetAttribute(){
        return $this->behavioral_sub_metric->low_target;
    }
    public function getMidTargetAttribute(){
        return $this->behavioral_sub_metric->mid_target;
    }
    public function getUpperTargetAttribute(){
        return $this->behavioral_sub_metric->upper_target;
    }
}
