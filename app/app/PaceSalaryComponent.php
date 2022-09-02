<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaceSalaryComponent extends Model
{
    protected $table = 'pace_salary_components';
    protected $fillable = ['id','name','pace_salary_category_id','type','gl_code','project_code','fixed','uses_days','constant','formula','amount','status','taxable','company_id','uses_anniversary'];

    public function pace_salary_category()
    {
    	return $this->belongsTo('App\PaceSalaryCategory','pace_salary_category_id');
    }
    public function exemptions()
    {
        return $this->belongsToMany('App\User','pace_salary_components_exemptions','pace_salary_component_id','user_id')->withTimestamps();
    }
    public function payrolls()
    {
        return $this->belongsToMany('App\Payroll','payroll_project_salary_component','salary_component_id','payroll_id');
    }
    public function project_salary_timesheets()
    {
        return $this->hasMany('App\ProjectSalaryTimesheet','pace_salary_component_id');
    }
}
