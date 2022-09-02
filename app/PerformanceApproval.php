<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceApproval extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'performance_approvals';
    protected $fillable = ['user_id','fiscal_year','approved_by','approved_at','evaluated_by','evaluated_at','user_remark','user_approved','user_approved_at'];

    public function employee()
	{
	    return $this->belongsTo('App\User', 'user_id');
	}
	public function manager()
	{
	    return $this->belongsTo('App\User', 'evaluated_by');
	}
    public function performance_assessments()
    {
        return $this->hasMany('App\PerformanceAssessment', 'performance_approval_id');
    }
}