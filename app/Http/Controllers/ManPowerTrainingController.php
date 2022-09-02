<?php

namespace App\Http\Controllers;

use App\Cadre;
use App\ManPowerTraining;
use App\Services\ManPowerApprovalService;
use App\User;
use App\UserGroup;
use App\Workflow;
use Illuminate\Http\Request;
use Auth;

class ManPowerTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('training_new.man_power.index');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //check configured workflow
        $workFlowCheckQuery = (new Workflow)->newQuery();
        $workFlowCheckQuery = $workFlowCheckQuery->where('name','man_power_workflow');
        if (!$workFlowCheckQuery->exists()){
            return [
                'message'=>'Workflow not configured with name (man_power_workflow)',
                'error'=>true
            ];
        }
        $workFlowObject = $workFlowCheckQuery->first();
//    	dd($request->all());

        //
        $obj = new ManPowerTraining;

//        $json = json_decode($request->getContent());

        $obj->name_of_institution = $request->get('name_of_institution');
        $obj->date_of_training = $request->get('date_of_training');
        $obj->total_cost_of_training = $request->get('total_cost_of_training');
        $obj->user_id = $request->get('user_id');
        $obj->requester_id = Auth::user()->id; // $request->get('requester_id');
        $obj->study_type = $request->get('study_type');

        $obj->study_leave_with_pay = $request->get('study_leave_with_pay');
//        $obj->study_leave_without_pay = 0;

//        if ($request->filled('study_leave_with_pay') && $request->get('study_type') == 'fulltime'){
//            $obj->study_leave_with_pay = 1;
//            $obj->study_leave_without_pay = 0;
//        }

//        if ($request->filled('withpay') && $request->get('study_type') == 'fulltime'){
//            $obj->study_leave_with_pay = 0;
//            $obj->study_leave_without_pay = 1;
//        }

        $obj->save();

        (new ManPowerApprovalService)->startStage($workFlowObject->id,$obj->id,$obj->user);


        return [
            'message'=>'Man Power Request Created',
            'error'=>false
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ManPowerTraining  $manPowerTraining
     * @return \Illuminate\Http\Response
     */
    public function show($path)
    {

    	//

        if ($path == 'fetch'){

        	$query = (new ManPowerTraining)->newQuery();
            $query = $query->orderBy('id','desc');

            return [
                'list'=>$query->get()
            ];

        }

        if ($path == 'fetch-cadre'){

          $query = (new Cadre)->newQuery();
//          $query = $query->get();

          return [
          	'list'=>$query->get()
          ];

        }

        if ($path == 'fetch-users'){

            $query = (new User)->newQuery();
//            $query = $query->get();

            return [
                'list'=>$query->get()
            ];

        }


        if ($path == 'fetch-groups'){
            $query = (new UserGroup)->newQuery();
            return [
                'list'=>$query->get()
            ];
        }

        if ($path == 'fetch-one-group' && request()->filled('id')){
            $query = (new UserGroup)->newQuery()->where('id',request('id'));
            return [
                'data'=>$query->first()
            ];
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ManPowerTraining  $manPowerTraining
     * @return \Illuminate\Http\Response
     */
    public function edit(ManPowerTraining $manPowerTraining)
    {
        //
        return [
            'data'=>$manPowerTraining,
            'error'=>false
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ManPowerTraining  $manPowerTraining
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManPowerTraining $manPowerTraining)
    {
        //
        $obj = $manPowerTraining;

        $obj->name_of_institution = $request->get('name_of_institution');
        $obj->date_of_training = $request->get('date_of_training');
        $obj->total_cost_of_training = $request->get('total_cost_of_training');
//        $obj->user_id = $request->get('user_id');
//        $obj->requester_id = Auth::user()->id; // $request->get('requester_id');
        $obj->study_type = $request->get('study_type');

        $obj->study_leave_with_pay = $request->get('study_leave_with_pay');
        $obj->study_leave_without_pay = 0;

//        if ($request->filled('withpay') && $request->get('study_type') == 'fulltime'){
//            $obj->study_leave_with_pay = 1;
//            $obj->study_leave_without_pay = 0;
//        }
//
//        if (!$request->filled('withpay') && $request->get('study_type') == 'fulltime'){
//            $obj->study_leave_with_pay = 0;
//            $obj->study_leave_without_pay = 1;
//        }

        $obj->save();

        return [
            'message'=>'Man Power Request Updated',
            'error'=>false
        ];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManPowerTraining  $manPowerTraining
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManPowerTraining $manPowerTraining)
    {
        //
        $manPowerTraining->delete();
        return [
            'message'=>'Record removed',
            'error'=>false
        ];
    }
}
