<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManPowerTraining extends Model
{
    //
    protected $fillable = ['name_of_institution','date_of_training',
        'total_cost_of_training','user_id',
        'requester_id','study_type','study_leave_with_pay','study_leave_without_pay','status'];

    function approvals(){
        return $this->hasMany(ManPowerTrainingApproval::class,'man_power_training_id');
    }

    function requester(){
        return $this->belongsTo(User::class,'requester_id');
    }

    function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
