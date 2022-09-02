<?php


namespace App\Traits;


use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

trait AuditTrait
{
    public function processGet($route,Request $request)
    {
        switch ($route) {
            case 'view_activity':
                # code...
                return $this->view_activity($request);
                break;
            case 'view_login_activity':
                # code...
                return $this->view_login_activity($request);
                break;
            case 'view_payroll_activity':
                # code...
                return $this->view_payroll_activity($request);
                break;
            case 'index':
                # code...
                return $this->get_trails($request);
                break;
            case 'view_salary_component_activity':
                # code...
                return $this->view_salary_component_activity($request);
                break;



            default:
                # code...
                break;

        }
    }

    public function processPost(Request $request){
        // try{


    }
    public function get_trails(Request $request){

        if ($request->filled('start_date')) {
            $dt_from=Carbon::parse($request->input('start_date'));
            $dt_to=Carbon::parse($request->input('end_date'));
            $activities=Activity::whereBetween('activity_log.created_at', [$dt_from,$dt_to])
            ->where('subject_type', 'App\User')->orderBy('id','desc')->paginate(10);
        }else{
            $activities=Activity::where('subject_type', 'App\User')->orderBy('id','desc')->paginate(10);
        }
         if ($request->excelall==true) {
                $view = 'audit.list-excel';
                // $employee_reimbursements=EmployeeReimbursement::where('company_id',companyId())->get();
                // return view('compensation.d365payroll',compact('payroll','allowances','deductions','income_tax','salary','date','has_been_run'));
                return \Excel::create("export", function ($excel) use ($activities, $view) {

                    $excel->sheet("export", function ($sheet) use ($activities, $view) {
                        $sheet->loadView("$view", compact('activities'))
                            ->setOrientation('landscape');
                    });

                })->export('xlsx');
            }

        $type='Employee Profile';
//
        $company_id = companyId();
       $setting=Setting::where(['name'=>'profile','company_id'=>$company_id])->first();
        return view('audit.list',compact('activities','type','setting'));
    }
    public function view_activity(Request $request){
          $activity = Activity::find($request->activity_id);
//       return $activity->changes['old']['name'];

    if ($request->type=='user'){
        return view('audit.partials.info',compact('activity'));
    } elseif ($request->type=='payroll'){
        return view('audit.partials.payroll_info',compact('activity'));
    }elseif ($request->type=='salary_component'){

    }elseif ($request->type=='payroll_policy'){

    }
    }
    public function view_payroll_activity(Request $request){
        if ($request->filled('start_date')) {
            $dt_from=Carbon::parse($request->input('start_date'));
            $dt_to=Carbon::parse($request->input('end_date'));
            $activities=Activity::whereBetween('activity_log.created_at', [$dt_from,$dt_to])
                ->where('subject_type', 'App\Payroll')->orderBy('id','desc')->paginate(10);
        }else{
            $activities=Activity::where('subject_type', 'App\Payroll')->orderBy('id','desc')->paginate(10);
        }
//        return $lastActivity = Activity::find(2)->changes['old']['name'];
    $type='payroll';
        $company_id = companyId();
        $setting=Setting::where(['name'=>$type,'company_id'=>$company_id])->first();
//        return count($activities);
        return view('audit.list',compact('activities','type','setting'));
    }
    public function view_salary_component_activity(Request $request){
        if ($request->filled('start_date')) {
            $dt_from=Carbon::parse($request->input('start_date'));
            $dt_to=Carbon::parse($request->input('end_date'));
            $activities=Activity::whereBetween('activity_log.created_at', [$dt_from,$dt_to])
                ->where('subject_type', 'App\SalaryComponent')->orderBy('id','desc')->paginate(10);
        }else{
            $activities=Activity::where('subject_type', 'App\SalaryComponent')->orderBy('id','desc')->paginate(10);
        }
//        return $lastActivity = Activity::find(2)->changes['old']['name'];
        $type='Salary Component';
//        return count($activities);
        $company_id = companyId();
        $setting=Setting::where(['name'=>'salary_component','company_id'=>$company_id])->first();
        return view('audit.list',compact('activities','type','setting'));
    }
    public function view_login_activity(Request $request){
        $users = User::where('company_id',companyId())->get();
//       return $activity->changes['old']['name'];


        return view('audit.login',compact('users'));
    }


}
