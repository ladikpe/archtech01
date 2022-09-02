<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BscEvaluationDetail extends Model
{
    protected $table="bsc_evaluation_details";
    public $appends= ['modified_date'];
   protected $fillable=['bsc_evaluation_id','metric_id','business_goal','measure','source','lower','mid','upper','actual','weighting','comment','crra','wcp'];
   public function metric()
    {
        return $this->belongsTo('App\BscMetric', 'metric_id');
    }
    public function evaluation()
    {
        return $this->belongsTo('App\BscEvaluation', 'bsc_evaluation_id');
    }

    public function getModifiedDateAttribute(){
        return date('Y-m-d',strtotime($this->updated_at));
    }
}
