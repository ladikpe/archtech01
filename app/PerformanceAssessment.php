<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceAssessment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'performance_assessments';
    protected $fillable = ['user_id','fiscal_year','performance_module_id','created_by','score','performance_approval_id'];

    public function user()
	{
	    return $this->belongsTo('App\User', 'created_by');
	}
    public function performance_module()
    {
        return $this->belongsTo('App\PerformanceModule', 'performance_module_id');
    }

    public function performance_approval()
    {
        return $this->belongsTo('App\PerformanceApproval', 'performance_approval_id');
    }
    public function employee(){
        return $this->belongsTo('App\User', 'user_id');
    }
}