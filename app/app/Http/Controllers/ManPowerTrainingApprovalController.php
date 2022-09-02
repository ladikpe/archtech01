<?php

namespace App\Http\Controllers;

use App\ManPowerTrainingApproval;
use App\Services\ManPowerApprovalService;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use Auth;

class ManPowerTrainingApprovalController extends Controller
{


    private $manPowerApprovalService;

    function __construct(ManPowerApprovalService $manPowerApprovalService)
    {
        $this->manPowerApprovalService = $manPowerApprovalService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id = request('id');
        $query = (new ManPowerTrainingApproval)->newQuery();
        $query = $query->where('man_power_training_id',$id)->orderBy('id','desc');

        $list = $query->get();

        foreach ($list as $k=>$item){
          $list[$k]->can_approve = false;
            if ($item->canApprove(Auth::user())){
                $list[$k]->can_approve = true;
            }
        }

//        PDFLib::

        return [
            'list'=>$list
        ];

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ManPowerTrainingApproval  $manPowerTrainingApproval
     * @return \Illuminate\Http\Response
     */
    public function show(ManPowerTrainingApproval $manPowerTrainingApproval)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ManPowerTrainingApproval  $manPowerTrainingApproval
     * @return \Illuminate\Http\Response
     */
    public function edit(ManPowerTrainingApproval $manPowerTrainingApproval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ManPowerTrainingApproval  $manPowerTrainingApproval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManPowerTrainingApproval $manPowerTrainingApproval)
    {
        //
        $status = $request->get('status');
        $user = $manPowerTrainingApproval->man_power_training->user;

        if ($status == 0){
            //reject
            $this->manPowerApprovalService->rejectStage($manPowerTrainingApproval,$user);
            return [
                'message'=>'Stage successfully rejected',
                'error'=>false
            ];
        }


        $this->manPowerApprovalService->approveStage($manPowerTrainingApproval,$user);
        return [
            'message'=>'Stage successfully approved',
            'error'=>false
        ];


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManPowerTrainingApproval  $manPowerTrainingApproval
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManPowerTrainingApproval $manPowerTrainingApproval)
    {
        //
    }
}
