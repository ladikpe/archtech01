<?php
namespace App\Traits;
use App\BscMetric;
use App\BscSubMetric;
use App\BscMeasurementPeriod;
use App\BscWeight;
use App\User;
use Auth;
use App\Department;
use App\Grade;
use App\GradeCategory;
use App\BscEvaluation;
use App\BscEvaluationDetail;
use App\Notifications\KPIsCreated;
use App\BehavioralEvaluationDetail;
use Excel;
use App\BscDet;
use App\Traits\Micellenous;
use App\BscDetDetail;
use Illuminate\Http\Request;

trait BSCEvaluationTrait{
    use Micellenous;
    public $performance_grades=["Poor Performance"=>[0,1.95], "Below Expectation"=>[1.96,2.45],  "Meets Expectation"=>[2.46,3.45],"Exceeds Expectation"=>[3.5,4]];

    public function processGet($route,Request $request){
        switch ($route) {
            case 'get_weight':
                # code...
                return $this->getWeight($request);
                break;
            case 'get_measurement_period':
                # code...
                return $this->getMeasurementPeriod($request);
                break;
            case 'get_evaluation_details':
                # code...
                return $this->getEvaluationDetails($request);
                break;
            case 'delete_evaluation_detail':
                # code...
                return $this->deleteEvaluationDetail($request);
                break;
            case 'get_evaluation_details_sum':
                # code...
                return $this->getEvaluationDetailsSum($request);
                break;
            case 'get_evaluation_wcp':
                # code...
                return $this->getEvaluationWcp($request);
                break;
            case 'get_evaluation':

                return $this->getEvaluation($request);
                break;
            case 'get_evaluation_user_list':

                return $this->getEvaluationUserList($request);
                break;
            case 'my_evaluations':

                return $this->getMyEvaluations($request);
                break;
            case 'get_my_evaluation':

                return $this->viewMyEvaluation($request);
                break;
            case 'use_dept_template':

                return $this->useDeptTemplate($request);
                break;
            case 'accept_kpis':

                return $this->acceptRejectKPIs($request);
                break;
            case 'submit_kpis_for_review':

                return $this->submitKPIsForReview($request);
                break;
            case 'manager_approve':

                return $this->managerApprove($request);
                break;
            case 'employee_approve':

                return $this->employeeApprove($request);
                break;
            case 'hr':

                return $this->hrIndex($request);
                break;
            case 'get_hr_department_list':

                return $this->departmentList($request);
                break;
            case  'performanceDiscussion':
                return $this->getPerformanceDiscussion($request);
                break;
            case  'dept_user_list':
                return $this->departmentUserList($request);
                break;
            case 'get_hr_evaluation':

                return $this->getHREvaluation($request);
                break;
            case 'get_behavioral_evaluation_wcp':

                return $this->getHREvaluation($request);
                break;
            case 'get_behavioral_evaluation_details':

                return $this->getBehavioralEvaluationDetails($request);
                break;
            case 'graph_report':

                return $this->graphChart($request);
                break;
            case 'bsc_mp_report':

                return $this->getBscMPReport($request);
                break;
            case 'ba_mp_report':

                return $this->getBAMPReport($request);
                break;
            case 'avg_report':

                return $this->getAvgMPReport($request);
                break;
            case 'dept_report':

                return $this->getDeptAvgMPReport($request);
                break;
            case 'excel_report':

                return $this->exportForBSCExcelReport($request);
                break;


            default:
                # code...
                break;
        }

    }


    public function processPost(Request $request){
        // try{
        switch ($request->type) {
            case 'get_evaluation':

                return $this->getEvaluation($request);
                break;
            case 'save_evaluation_detail':
                # code...
                return $this->saveEvaluationDetail($request);
                break;
            case 'measurementperiod':
                # code...
                return $this->saveMeasurementPeriod($request);
                break;
            case 'save_evaluation_comment':
                # code...
                return $this->saveEvaluationComment($request);
                break;
            case 'import_emeasures':
                # code...
                return $this->importTemplate($request);
                break;
            case 'saveDiscussion':
                return $this->saveDiscussion($request);
                break;
            case 'save_behavioral_evaluation_detail':
                # code...
                return $this->saveBehavioralEvaluationDetail($request);
                break;
            default:
                # code...
                break;
        }
        // }
        // catch(\Exception $ex){
        // 	return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        // }
    }

    public function getEvaluationUserList(Request $request)
    {

        $mp=BscMeasurementPeriod::find($request->mp);
        $manager=Auth::user();
        $sql = User::whereHas('managers', function ($query) use($manager) {
	        $query->where('manager_id',  $manager->id);
        })->where('hiredate','<=',$mp->to)->where('status','!=',2)->toSql();
//        dd($sql);
        $users=User::whereHas('managers', function ($query) use($manager) {
            $query->where('manager_id',  $manager->id);
        })->where('hiredate','<=',$mp->to)->where('status','!=',2)->get();
        return view('bsc.users_list',compact('users','mp'));

    }
    public function getMyEvaluations(Request $request)
    {

        $evaluations=BscEvaluation::where(['user_id'=>Auth::user()->id])->get();
        return view('bsc.user_index',compact('evaluations'));
    }

    public function viewMyEvaluation(Request $request)
    {
        $evaluation=BscEvaluation::find($request->evaluation);
        $metrics=BscMetric::all();
        $user=$evaluation->user;
        if ( $evaluation->user_id==Auth::user()->id) {
            if ($evaluation) {

                return view('bsc.view_evaluation',compact('evaluation','metrics','user'));
            }else{
                $request->session()->flash('error', 'User does not have a grade category or a department');
                return redirect()->back();
            }
        }else{
            $request->session()->flash('error', 'You cannot view this evaluation');
            return redirect()->back();
        }

    }
    public function acceptRejectKPIs(Request $request)
    {
        $evaluation=BscEvaluation::find($request->bsc_evaluation_id);
        if ($evaluation && $evaluation->user_id==Auth::user()->id) {
            $evaluation->update(['kpi_accepted'=>$request->action,'date_kpi_accepted'=>date('Y-m-d')]);
            return 'success';
        }
        return 'error';

    }
    public function submitKPIsForReview(Request $request)
    {
        $evaluation=BscEvaluation::find($request->bsc_evaluation_id);
        // dd($evaluation)
        //https://pal.hcmatrix.com/bsc/get_evaluation?employee=1048&mp=5
        if ($evaluation->user_id == Auth::user()->id) {
            $evaluation->update(['kpi_accepted'=>0,'date_kpi_accepted'=>null, 'submitted_for_review'=>1,'date_submitted_for_review'=>date('Y-m-d'),'evaluator_id'=>Auth::user()->id]);
            $evaluation->user->plmanager->notify((new KPIsCreated($evaluation,"bsc/get_evaluation?employee=$evaluation->user->id&mp=$evaluation->measurement_period->id")));
            return 'success';
        }else {
            $evaluation->update(['kpi_accepted'=>0,'date_kpi_accepted'=>null, 'submitted_for_review'=>1,'date_submitted_for_review'=>date('Y-m-d'),'evaluator_id'=>Auth::user()->id]);
            $evaluation->user->notify((new KPIsCreated($evaluation,"bsc/get_my_evaluation?evaluation=$evaluation->id")));
            return 'success';
        }

    }
    public function managerApprove(Request $request)
    {
        $evaluation=BscEvaluation::find($request->bsc_evaluation_id);
        if ($evaluation) {
            $evaluation->update(['manager_approved'=>1,'date_manager_approved'=>date('Y-m-d'),'evaluator_id'=>Auth::user()->id]);
            return 'success';
        }
        return 'error';

    }
    public function employeeApprove(Request $request)
    {
        $evaluation=BscEvaluation::find($request->bsc_evaluation_id);
        if ($evaluation && $evaluation->user_id==Auth::user()->id) {
            $evaluation->update(['employee_approved'=>1,'date_employee_approved'=>date('Y-m-d')]);
            return 'success';
        }
        return 'error';

    }
    public function getEvaluation(Request $request)
    {

        $user=User::find($request->employee);
        $mp=BscMeasurementPeriod::find($request->mp);
        $bsms=\App\BehavioralSubMetric::where(['status'=>1,'company_id'=>companyId()])->get();
        $operation='evaluate';
        if ($user->grade&&$user->job) {
            if ($user->job) {
                if (!$user->grade->performance_category) {
                    $request->session()->flash('error', 'User does not have a Performance category or a department');
                    return redirect()->back();
                }else{
                    $evaluation=BscEvaluation::where(['user_id'=>$user->id,'bsc_measurement_period_id'=>$mp->id])->with(['behavioral_evaluation_details'])->first();

                    if($evaluation){
                        foreach ($bsms as $bsm) {
                            $evaluation_detail=BehavioralEvaluationDetail::firstOrCreate(['bsc_evaluation_id'=>$evaluation->id,'behavioral_sub_metric_id'=>$bsm->id]);
                        }
                        $metrics=BscMetric::all();

                        return view('bsc.evaluation',compact('user','operation','evaluation','metrics','bsms'));

                    }else{


                        $evaluation=BscEvaluation::create(['user_id'=>$user->id,'bsc_measurement_period_id'=>$mp->id,'department_id'=>$user->job->department_id,'performance_category_id'=>$user->grade->performance_category->id,'company_id'=>companyId()]);
                        foreach ($bsms as $bsm) {

                            $evaluation_detail=BehavioralEvaluationDetail::firstOrCreate(['bsc_evaluation_id'=>$evaluation->id,'behavioral_sub_metric_id'=>$bsm->id]);
                        }
                        $metrics=BscMetric::all();

                        return view('bsc.evaluation',compact('user','operation','evaluation','metrics','bsms'));



                    }
                }
            }else{
                $request->session()->flash('error', 'User does not have a department ');
            }



        }elseif(!$user->grade){
            $request->session()->flash('error', 'User does not have a grade  or job ');
            return redirect()->back();
        }else{
            return  redirect()->back();

        }


    }

    public function saveEvaluationDetail(Request $request)
    {

        $crra=$this->calc_result_achieved($request);
        $evaluation_detail=BscEvaluationDetail::updateOrCreate(['id'=>$request->id],['bsc_evaluation_id'=>$request->bsc_evaluation_id,'metric_id'=>$request->metric_id,'business_goal'=>$request->business_goal,'measure'=>$request->measure,'source'=>$request->source,'lower'=>$request->lower,'mid'=>$request->mid,'upper'=>$request->upper,'actual'=>$request->actual,'weighting'=>$request->weighting,'comment'=>$request->comment,'crra'=>$crra,'wcp'=>($request->weighting/100)*$crra]);

        $wcpSum=BscEvaluationDetail::where('bsc_evaluation_id',$evaluation_detail->bsc_evaluation_id)->sum('wcp');
        $evaluation=BscEvaluation::updateorCreate(['id'=>$evaluation_detail->bsc_evaluation_id],['score'=>$wcpSum,'submitted_for_review'=>1,'date_submitted_for_review'=>date('Y-m-d'),'manager_approved'=>0,'date_manager_approved'=>date('Y-m-d'),'employee_approved'=>0,'date_employee_approved'=>date('Y-m-d'),'company_id'=>companyId()]);

        $this->notifyUserKpiChange($evaluation->user_id,$evaluation_detail->bsc_evaluation_id);

        return $evaluation_detail;


    }
    public function importTemplate(Request $request)
    {
        $document = $request->file('template');
        $evaluation=BscEvaluation::find($request->evaluation_id);
        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        if($request->hasFile('template')){

            $datas=\Excel::load($request->file('template')->getrealPath(), function($reader) {
                $reader->noHeading()->skipRows(1);
            })->get();

            foreach ($datas[0] as $data) {
                // dd($data[0]);
                if ($data[0]) {
                    $metric=BscMetric::where('name',$data[0])->first();
                    $det_detail=BscEvaluationDetail::create(['bsc_evaluation_id'=>$request->evaluation_id,'metric_id'=>$metric->id,'business_goal'=>$data[1],'measure'=>$data[3],'source'=>$data[4],'lower'=>$data[5],'mid'=>$data[6],'upper'=>$data[7],'weighting'=>$data[2]*100]);


                }

            }



            //      Excel::load($request->file('template')->getRealPath(), function ($reader) use($det) {
            //      	// dd($reader->toArray());

            //      	foreach ($reader->toArray() as $key => $row) {

            //      		if ($row[0][0]['perspective']) {
            //      			$metric=BscMetric::where('name',$row[0][0]['perspective'])->first();
            //      			 $det_detail=BscDetDetail::create(['bsc_det_id'=>$det->id,'bsc_metric_id'=>$metric->id,'business_goal'=>$row[0][0]['business_goal'],'measure'=>$row[0][0]['measure'],'lower'=>$row[0][0]['lower'],'mid'=>$row[0][0]['mid_target'],'upper'=>$row[0][0]['upper_target'],'weighting'=>$row[0][0]['weighting']*100]);


            //      		}


            // }
            //      });

            // $request->session()->flash('success', 'Import was successful!');

            return 'success';
        }

    }

    public function getEvaluationDetails(Request $request)
    {
        return $evaluation_details=BscEvaluationDetail::where(['bsc_evaluation_id'=>$request->bsc_evaluation_id,'metric_id'=>$request->metric_id])->get();

    }
    public function useDeptTemplate(Request $request)
    {
        $evaluation=BscEvaluation::find($request->bsc_evaluation_id);
        if ($evaluation) {
            $det=BscDet::where(['department_id'=>$evaluation->department->id,'measurement_period_id'=>$evaluation->measurement_period->id])->first();
            foreach ($det->details as $detail) {
                $evaluation->evaluation_details()->create(['metric_id'=>$detail->bsc_metric_id,'business_goal'=>$detail->business_goal,'measure'=>$detail->measure,'lower'=>$detail->lower,'mid'=>$detail->mid,'upper'=>$detail->upper,'weighting'=>$detail->weighting]);
            }
            return 'success';
        }

    }
    public function getEvaluationWcp(Request $request)
    {
        $evaluation=BscEvaluation::find($request->bsc_evaluation_id);
        return ['evaluation'=>$evaluation,'remark'=>$this->calc_Performance($evaluation->score)];

    }
    public function saveEvaluationComment(Request $request)
    {
        $evaluation=BscEvaluation::find($request->bsc_evaluation_id);
        $evaluation->update(['comment'=>$request->comment]);
        return 'success';
    }

    public function deleteEvaluationDetail(Request $request)
    {
        $evaluation_detail=BscEvaluationDetail::find($request->id);
        $evaluation_detail->delete();

    }
    public function getEvaluationDetailsSum(Request $request)
    {
        return $sum=BscEvaluationDetail::where(['bsc_evaluation_id'=>$request->bsc_evaluation_id,'metric_id'=>$request->metric_id])->sum('weighting');
    }

    public function calc_Performance($summed_performance){
        if($summed_performance<=1.95){
            return "Poor Performance";
        }
        elseif($summed_performance<=2.45){
            return "Below Expectation";
        }
        elseif($summed_performance>=3.5){
            return "Exceeds Expectation";
        }
        elseif($summed_performance<=3.45){
            return "Meets Expectation";
        }
        else{
            return "";
        }
    }

    public function weighted_contribution(Request $request){
        $weighing=$request->weighing;
        $calc_result_achieved=$this->calc_result_achieved($request);
        return $weighing * $calc_result_achieved;
    }

    public function calc_result_achieved(Request $request)
    {

        $lower= $request->lower;
        $mid_target= $request->mid;
        $upper_target= $request->upper;
        $act_result= $request->actual;


        if($lower<$mid_target){

            if($mid_target<$upper_target){

                if($act_result==""){
                    return 1;
                }
                else{
                    if($act_result>=$upper_target){
                        return 4;
                    }
                    else{
                        if($act_result<=$lower){
                            return 1;
                        }
                        else{
                            if($act_result==$mid_target){
                                return 2.5;
                            }
                            else{
                                if($act_result>$mid_target){
                                    return 4-($upper_target-$act_result)/($upper_target-$mid_target);
                                }
                                else{
                                    if($mid_target<$act_result ||$act_result>=$lower){
                                        return 2.5-($mid_target-$act_result)/($mid_target-$lower);


                                    }
                                }
                            }
                        }
                    }
                }
            }
            else{
                if($act_result==""){
                    return 1;
                }
                else{
                    if($act_result>=$lower){
                        return 1;
                    }
                    else{
                        if($act_result<=$upper_target){
                            return 4;
                        }
                        else{
                            if($act_result==$mid_target){
                                return 2.5;
                            }
                            else{
                                if($act_result>=$mid_target){
                                    return 1+($lower-$act_result)/(($lower-$mid_target));
                                }
                                else{
                                    if($mid_target<$act_result || $act_result>=$upper_target){
                                        return 2.5+($mid_target-$act_result)/($mid_target-$upper_target);
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
    }
    public function departmentList(Request $request)
    {
        $company_id=companyId();
        $mp=BscMeasurementPeriod::find($request->mp_id);
        if ($company_id==0) {
            $departments=Department::paginate(10);
        } else {
            $departments=Department::where('company_id',$company_id)->get();
        }

        return view('bsc.department_list',compact('departments','mp'));
    }
    public function measurementPeriodDepartmentUsers(Request $request)
    {
        $company_id=companyId();
        if ($company_id==0) {
            $departments=Department::paginate(10);
        } else {
            $departments=Department::where('company_id',$company_id)->get();
        }

        return view('bsc.department_list',compact('departments'));
    }


    public function getPerformanceDiscussion(Request $request){
        $discussions=\App\PerformanceDiscussion::where('evaluation_id',$request->evaluation_id)->get();
        return view('bsc.ajax.performanceDiscussion',compact('discussions'));
    }

    public function saveDiscussion(Request $request){
        // could become a potential problem better to use $request->id in the where clause, but this has its own importance
        $saveDiscussion=\App\PerformanceDiscussion::updateOrCreate(['title'=>$request->title,'discussion'=>$request->discussion],$request->except('_token'));
        $this->nofityHrAdminSaveDiscussion($saveDiscussion);
        return $this->getPerformanceDiscussion($request);
        // response()->json(['status'=>'success','message'=>'Pefromance Discussion Succsessfully Saved']);

    }


    // incase it was requested
    public function deletePerformanceDiscussion(Request $request){
        \App\PefromanceDiscussion::where('id',$request->id)->delete();
        return getPerformanceDiscussion($request);
    }
    public function hrIndex(Request $request)
    {
        $company_id=companyId();
        $company=\App\Company::find($company_id);
        $metrics=\App\BscMetric::all();
        $measurement_periods=BscMeasurementPeriod::all();
        $weights=\App\BscWeight::all();
        $departments=Department::where('company_id',$company_id)->get();
        $grade_categories=GradeCategory::all();
        $user=new User();
        $operation='select';

        return view('bsc.hr_index',compact('metrics','measurement_periods','weights','departments','grade_categories','user','operation'));//

    }
    public function departmentUserList(Request $request)
    {
        $company_id=companyId();
        $mp=BscMeasurementPeriod::find($request->mp);
        $department=Department::find($request->department);
        if (isset($mp) & isset($department)) {

            $users=$department->users()->where('hiredate','<=',$mp->to)->where('status','!=',2)->get();

            return view('bsc.hr_users_list',compact('department','users','mp'));
        }else{
            return  redirect()->back();
        }

    }
    public function getHREvaluation(Request $request)
    {

        $user=User::find($request->employee);
        $mp=BscMeasurementPeriod::find($request->mp);
        $operation='evaluate';
        if ($user->grade&&$user->job) {
            if ($user->job) {
                if (!$user->grade->performance_category) {
                    $request->session()->flash('error', 'Employee does not have a grade category or a department');
                    return redirect()->back();
                }else{
                    $evaluation=BscEvaluation::where(['user_id'=>$user->id,'bsc_measurement_period_id'=>$mp->id])->first();
                    if($evaluation){
                        $metrics=BscMetric::all();

                        return view('bsc.hr_view_evaluation',compact('user','operation','evaluation','metrics'));

                    }else{


                        $request->session()->flash('error', 'Employee has not been evaluated.');



                    }
                }
            }else{
                $request->session()->flash('error', 'Employee does not have a department ');
            }



        }elseif(!$user->grade){
            $request->session()->flash('error', 'Employee does not have a grade  or job ');
            return redirect()->back();
        }else{
            return  redirect()->back();

        }


    }

    public function saveBehavioralEvaluationDetail(Request $request)
    {


        $evaluation_detail=BehavioralEvaluationDetail::updateOrCreate(['id'=>$request->id],['bsc_evaluation_id'=>$request->bsc_evaluation_id,'actual'=>$request->actual,'comment'=>$request->comment]);
        $crra=$this->behavioral_calc_result_achieved($evaluation_detail);
        $evaluation_detail->update(['crra'=>$crra,'wcp'=>($request->weighting/100)*$crra]);
        $wcpSum=BehavioralEvaluationDetail::where('bsc_evaluation_id',$evaluation_detail->bsc_evaluation_id)->sum('wcp');
        $evaluation=BscEvaluation::updateorCreate(['id'=>$evaluation_detail->bsc_evaluation_id],['behavioral_score'=>$wcpSum,'submitted_for_review'=>1,'date_submitted_for_review'=>date('Y-m-d'),'manager_approved'=>0,'date_manager_approved'=>date('Y-m-d'),'employee_approved'=>0,'date_employee_approved'=>date('Y-m-d'),'company_id'=>companyId()]);

        $this->notifyUserKpiChange($evaluation->user_id,$evaluation_detail->bsc_evaluation_id);

        return $evaluation_detail;


    }
    public function getBehavioralEvaluationDetails(Request $request)
    {
        return $evaluation_details=\App\BehavioralEvaluationDetail::where(['bsc_evaluation_id'=>$request->bsc_evaluation_id])->get();

    }

    public function behavioral_calc_result_achieved(BehavioralEvaluationDetail $evaluation_detail)
    {


        $lower= $evaluation_detail->lower_target;
        $mid_target= $evaluation_detail->mid_target;
        $upper_target= $evaluation_detail->upper_target;
        $act_result= $evaluation_detail->actual;


        if($lower<$mid_target){

            if($mid_target<$upper_target){

                if($act_result==""){
                    return 1;
                }
                else{
                    if($act_result>=$upper_target){
                        return 4;
                    }
                    else{
                        if($act_result<=$lower){
                            return 1;
                        }
                        else{
                            if($act_result==$mid_target){
                                return 2.5;
                            }
                            else{
                                if($act_result>$mid_target){
                                    return 4-($upper_target-$act_result)/($upper_target-$mid_target);
                                }
                                else{
                                    if($mid_target<$act_result ||$act_result>=$lower){
                                        return 2.5-($mid_target-$act_result)/($mid_target-$lower);


                                    }
                                }
                            }
                        }
                    }
                }
            }
            else{
                if($act_result==""){
                    return 1;
                }
                else{
                    if($act_result>=$lower){
                        return 1;
                    }
                    else{
                        if($act_result<=$upper_target){
                            return 4;
                        }
                        else{
                            if($act_result==$mid_target){
                                return 2.5;
                            }
                            else{
                                if($act_result>=$mid_target){
                                    return 1+($lower-$act_result)/(($lower-$mid_target));
                                }
                                else{
                                    if($mid_target<$act_result || $act_result>=$upper_target){
                                        return 2.5+($mid_target-$act_result)/($mid_target-$upper_target);
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
    }

    public function graphChart(Request $request)
    {
        $company_id=companyId();
        $mp=BscMeasurementPeriod::find($request->mp_id);
        return view('bsc.graph_report',compact('mp'));
    }
    public function getBscMPReport(Request $request)
    {

        $data=[];



        // $leaves=Leave::where('company_id',comapnyId())->get();




        foreach ($this->performance_grades as $key => $performance_grade) {
            $data['labels'][]=$key;

            $data['data'][]=BscEvaluation::where(['company_id'=>companyId(),'bsc_measurement_period_id'=>$request->mp_id])->whereBetween('score',$performance_grade)->count();

        }

        return $data;





    }

    public function getBAMPReport(Request $request)
    {

        $data=[];



        // $leaves=Leave::where('company_id',comapnyId())->get();



        foreach ($this->performance_grades as $key => $performance_grade) {
            $data['labels'][]=$key;

            $data['data'][]=BscEvaluation::where(['company_id'=>companyId(),'bsc_measurement_period_id'=>$request->mp_id])->whereBetween('behavioral_score',$performance_grade)->count();




        }
        return $data;





    }
    public function getAvgMPReport(Request $request)
    {

        $data=[];


        // $leaves=Leave::where('company_id',comapnyId())->get();



        foreach ($this->performance_grades as $key => $performance_grade) {
            $data['labels'][]=$key;
            $data['data'][]=BscEvaluation::selectRaw(' ((behavioral_score+score)/2) as avgs')->where(['company_id'=>companyId(),'bsc_measurement_period_id'=>$request->mp_id])->get()->filter(function ($value, $key) use($performance_grade) {
                if($value->avgs>=$performance_grade[0] and $value->avgs<=$performance_grade[1] ){
                    return $value->avgs;
                };
            })->count();
        }
        return $data;





    }
    public function getDeptAvgMPReport(Request $request)
    {

        $data=[];


        // $leaves=Leave::where('company_id',comapnyId())->get();
        $departments=\App\Department::where('company_id',companyId())->get();
        foreach ($departments as $department) {
            $data['labels'][]=$department->name;
        }
        $pk=0;
        foreach ($this->performance_grades as $key => $performance_grade) {
            $data['datasets'][$pk]['label']=$key;
            foreach ($departments as $department) {
                $user_ids=$department->users->pluck('id');

                $data['datasets'][$pk]['data'][]=BscEvaluation::selectRaw(' ((behavioral_score+score)/2) as avgs')->whereIn('user_id', $user_ids)->where(['company_id'=>companyId(),'bsc_measurement_period_id'=>$request->mp_id])->get()->filter(function ($value, $key) use($performance_grade) {
                    if($value->avgs>=$performance_grade[0] and $value->avgs<=$performance_grade[1] ){
                        return $value->avgs;
                    };
                })->count();
            }
            $pk++;

        }
        return $data;





    }
    public function exportForBSCExcelReport(Request $request)
    {

        $data=[];
        $mp=BscMeasurementPeriod::find($request->mp_id);

        return     \Excel::create("BSC export for ".date('F-Y',strtotime($mp->from))." to ".date('F-Y',strtotime($mp->to)), function($excel) use ($request) {

            $type=$request->type;
            $evaluations=BscEvaluation::where(['company_id'=>companyId(),'bsc_measurement_period_id'=>$request->mp_id])->get();
            if($type=='score'){
                $excel->sheet('performance report', function($sheet) use ($evaluations) {

                    $sheet->loadView('bsc.partials.bsc_report',compact('evaluations'))->setOrientation('landscape');
                });
            }elseif($type=='behavioral_score'){
                $excel->sheet('performance report', function($sheet) use ($evaluations) {

                    $sheet->loadView('bsc.partials.ba_report',compact('evaluations'))->setOrientation('landscape');
                });

            }elseif($type=='average'){
                $excel->sheet('performance report', function($sheet) use ($evaluations) {

                    $sheet->loadView('bsc.partials.avg_report',compact('evaluations'))->setOrientation('landscape');
                });

            }
        })->export('xlsx');
    }


}
