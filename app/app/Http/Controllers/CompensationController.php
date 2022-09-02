<?php

namespace App\Http\Controllers;

use App\PayrollPolicy;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Traits\PayrollTrait;
use App\User;
use App\Payroll;
use App\Company;

class CompensationController extends Controller
{
    use PayrollTrait;
    public function index()
    {
        $company_id=companyId();
        if ($company_id==0) {
            $payroll=Payroll::where(['month'=>date('m'),'year'=>date('Y'),'company_id'=>$company_id])->first();
            if ($payroll) {
                $date=date('Y-m-d');
                $allowances=0;
                $deductions=0;
                $income_tax=0;
                $salary=0;
                $has_been_run=1;
                foreach ($payroll->payroll_details as $detail) {
                    $salary+=$detail->basic_pay;
                    $allowances+=$detail->allowances;
                    $deductions+=$detail->deductions;
                    $income_tax+=$detail->paye;

                }

                return view('compensation.payroll',compact('payroll','allowances','deductions','income_tax','salary','date','has_been_run'));
            } else {
                $has_been_run=0;
                $employees=User::whereHas('promotionHistories.grade')->get();
                $date=date('Y-m-d');

                return view('compensation.payroll',compact('date','employees','has_been_run'));

            }

        }

        $payroll=Payroll::where(['month'=>date('m'),'year'=>date('Y'),'company_id'=>$company_id])->first();
        if ($payroll) {
            $date=date('Y-m-d');
            $allowances=0;
            $deductions=0;
            $income_tax=0;
            $salary=0;
            $has_been_run=1;
            foreach ($payroll->payroll_details as $detail) {
                $salary+=$detail->basic_pay;
                $allowances+=$detail->allowances;
                $deductions+=$detail->deductions;
                $income_tax+=$detail->paye;

            }

            return view('compensation.payroll',compact('payroll','allowances','deductions','income_tax','salary','date','has_been_run'));
        } else {
            $has_been_run=0;
            $employees=Company::where('id',$company_id)->first()->users()->has('promotionHistories.grade')->get();
            $date=date('Y-m-d');

            return view('compensation.payroll',compact('date','employees','has_been_run'));

        }


    }
    public function store(Request $request)
    {
        //
        return $this->processPost($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        return $this->processGet($id,$request);
    }
    public function nav_int(Request $request)
    {
        if($request->key== env('APP_KEY')) {
            $months = ['jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4, 'may' => 5, 'jun' => 6, 'jul' => 7, 'aug' => 8, 'sep' => 9, 'oct' => 10, 'nov' => 11, 'dec' => 12];
            if(!array_key_exists(($request->month),$months)){

                return response()->json(['status'=>'error','message'=>'enter the month like jan or feb'],400);

            }
            $payroll = Payroll::where(['month' => $months[($request->month)], 'year' => $request->year])->first();
            if(!$payroll){
                return response()->json(['status'=>'error','message'=>'payroll has not been processed for this month'],400);
            }
            $company_id = 8;

            $sections = \App\UserSection::where('company_id', $company_id)->with('users.user_groups')->get();
            $allusers = \App\User::where('company_id', $company_id)->with('user_groups')->get();
            // return ($allusers);

            $chart_of_accounts = \App\ChartOfAccount::where(['company_id' => $company_id, 'status' => 1,])->orderBy('position')->get();
            $payroll_details = $payroll->payroll_details;
            $specific_salary_component_types = \App\SpecificSalaryComponentType::where('company_id', $company_id)->get();
            $users = \App\User::where('company_id', $company_id)->with('user_groups')->get();
            $lsas = \App\LongServiceAward::where('company_id', $company_id)->orderBy('max_year', 'ASC')->get();
            $pp = PayrollPolicy::where('company_id', $company_id)->first();

            if ($payroll) {

                $days = cal_days_in_month(CAL_GREGORIAN, $payroll->month, $payroll->year);
                $date = date('Y-m-d', strtotime($payroll->year . '-' . $payroll->month . '-' . $days));

                return view('compensation.partials.navpayroll_int', compact('sections', 'payroll', 'chart_of_accounts', 'payroll_details', 'date', 'specific_salary_component_types', 'allusers', 'pp', 'lsas'));
//
            }

        }
        else{
            return response()->json(['status'=>'error','message'=>'Invalid Key'],400);
        }
    }
}
