<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;


class LeaveRequest extends Model
{

    protected $fillable=['leave_id','start_date','end_date','paystatus','length','reason','absence_doc','user_id','workflow_id','status','company_id','replacement_id','balance'];
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(new CompanyScope);
    // }

     public function leave()
    {
    	return $this->belongsTo('App\Leave','leave_id');
    }
    public function leave_approvals()
    {
    	return $this->hasMany('App\LeaveApproval','leave_request_id');
    }
     public function user()
    {
    	return $this->belongsTo('App\User','user_id')->withoutGlobalScopes();
    }
    public function workflow()
    {
        return $this->belongsTo('App\Workflow','workflow_id');
    }
    public function replacement()
    {
        return $this->belongsTo('App\User','replacement_id')->withoutGlobalScopes();
    }
    public function getLeaveNameAttribute()
    {
        if ($this->leave_id==0) {
           return "Annual Leave";
        }else{
            return $this->leave->name;
        }
    }
}
