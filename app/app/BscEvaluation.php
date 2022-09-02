<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BscEvaluation extends Model
{
   protected $table="bsc_evaluations";
   protected $fillable=['kpi_accepted','date_kpi_accepted','user_id','bsc_measurement_period_id','department_id','performance_category_id','comment','score','manager_approved','evaluator_id','manager_approved','employee_approved','date_employee_approved','date_manager_approved','behavioral_score','company_id'];

   public function measurement_period()
    {
        return $this->belongsTo('App\BscMeasurementPeriod', 'bsc_measurement_period_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function evaluator()
    {
        return $this->belongsTo('App\User', 'evaluator_id');
    }
    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }
    public function performance_category()
    {
        return $this->belongsTo('App\BscGradePerformanceCategory', 'performance_category_id');
    }
    public function evaluation_details()
    {
        return $this->hasMany('App\BscEvaluationDetail', 'bsc_evaluation_id');
    }
    public function behavioral_evaluation_details()
    {
        return $this->hasMany('App\BehavioralEvaluationDetail', 'bsc_evaluation_id');
    }

    public function getStatusTextAttribute(){
        if($this->kpi_accepted==1){
            return "Accepted @ {$this->date_kpi_accepted}";
        }
        elseif($this->kpi_accepted==2){
            return "Rejected @ {$this->date_kpi_accepted}";
        }
        else{
            return "Pending";
        }
        
    }

    public function getStatusColorAttribute(){
        if($this->kpi_accepted==1){
            return "success";
        }
        elseif($this->kpi_accepted==2){
            return "danger";
        }
        else{
            return "warning";
        }
    }
}
