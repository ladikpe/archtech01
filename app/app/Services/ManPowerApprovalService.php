<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/10/2020
 * Time: 21:39
 */

namespace App\Services;


use App\ManPowerTrainingApproval;
use App\Stage;
use App\Traits\WithWorkflowStage;
use App\User;
use Auth;

class ManPowerApprovalService
{
    use WithWorkflowStage;

    function onEnableApprovalStage(Stage $stage, $objApproval)
    {
        // TODO: Implement onEnableApprovalStage() method.
        $objApproval->status = 1;
        $objApproval->approver_id = Auth::user()->id;
        $objApproval->comments = request('comments');
        $objApproval->save();

    }

    function onEnableFinalApprovalStage(Stage $stage, $objApproval)
    {
        // TODO: Implement onEnableFinalApprovalStage() method.
        $objApproval->status = 1;
        $objApproval->approver_id = Auth::user()->id;
        $objApproval->comments = request('comments');
        $objApproval->save();

        $objApproval->man_power_training->status = 1;
        $objApproval->man_power_training->save();

    }

    function onRejectApprovalStage(Stage $stage, $objApproval)
    {
        // TODO: Implement onRejectApprovalStage() method.
        $objApproval->status = 0;
        $objApproval->approver_id = Auth::user()->id;
        $objApproval->comments = request('comments');
        $objApproval->save();
    }


    function onCreateApprovalStage(Stage $stage, $objApproval)
    {
        // TODO: Implement onCreateApprovalStage() method.
        //'man_power_training_id','stage_id','approver_id','comments','status','signature'
        $obj = new ManPowerTrainingApproval;

        $obj->man_power_training_id = is_object($objApproval)? $objApproval->man_power_training_id : $objApproval;
        $obj->stage_id = $stage->id;
        $obj->comments = 'Your comments goes in here.';
        $obj->status = 0;

        $obj->save();
    }

    function onNotifyUserApprove(User $user, Stage $stage, $objApproval)
    {
        // TODO: Implement onNotifyUserApprove() method.
    }

    function onNotifyUserReject(User $user, Stage $stage, $objApproval)
    {
        // TODO: Implement onNotifyUserReject() method.
    }

    function initStage($workFlowId,$foreignKey,$user){
        $this->startStage($workFlowId,$foreignKey,$user);
    }

    //(new LoanApprovalService)->initStage($loan_policy->workflow_id,$loan_request->id,$loan_request->user);

}