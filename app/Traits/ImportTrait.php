<?php

namespace App\Traits;

use App\AperMeasurementPeriod;
use App\Bank;
use App\Dependant;
use App\Notifications\NewUserCreatedNotify;
use App\Qualification;
use Illuminate\Http\Request;
use Auth;
use Excel;
use DB;
use App\User;
use App\Branch;
use App\Company;
use App\Department;
use App\Job;
use App\Grade;


trait ImportTrait {
    public $allowed=['xls','xlsx','csv'];
    public function processGet($route,Request $request){
        switch ($route) {
            case 'employees':
                # code...
                return $this->viewEmployeesImport($request);
                break;
            case 'departments':
                # code...
                return $this->viewDepartmentsImport($request);
                break;
            case 'branches':
                # code...
                return $this->viewBranchesImport($request);
                break;
            case 'jobroles':
                # code...
                return $this->viewJobrolesImport($request);
                break;
            case 'grades':
                # code...
                return $this->viewGradesImport($request);
                break;
            case 'update_dob':
                # code...
                return $this->viewUpdateDobImport($request);
                break;
            case 'download_employee_template':
                # code...
                return $this->downloadEmployeeUploadTemplate($request);
                break;
            case 'download_jobroles_template':
                # code...
                return $this->downloadJobRolesTemplate($request);
                break;
            case 'download_grades_template':
                # code...
                return $this->downloadGradeTemplate($request);
                break;
            case 'download_branches_template':
                # code...
                return $this->downloadBranchTemplate($request);
                break;
            case 'download_department_template':
                # code...
                return $this->downloadDepartmentTemplate($request);
                break;
            case 'download_academic_qualification_template':
                # code...
                return $this->downloadAcademicQualificationTemplate($request);
                break;
            case 'download_dependent_template':
                # code...
                return $this->downloadDependentTemplate($request);
                break;
            case 'download_work_experience_template':
                # code...
                return $this->downloadWorkExperienceTemplate($request);
                break;
            case 'update_aper_assessment_details':
                # code...
                return $this->ImportAperAssessmentDetails($request);
                break;
            default:
                # code...
                break;
        }

    }


    public function processPost(Request $request){
        // try{
        switch ($request->type) {
            case 'employees':
                # code...
                return $this->importUsers($request);
                break;
            case 'departments':
                # code...
                return $this->importDepartments($request);
                break;
            case 'branches':
                # code...
                return $this->importBranches($request);
                break;
            case 'jobroles':
                # code...
                return $this->importJobroles($request);
                break;
            case 'grades':
                # code...
                return $this->importGrades($request);
                break;
            case 'dependents':
                # code...
                return $this->importDependants($request);
                break;
            case 'update_dob':
                # code...
                return $this->importDob($request);
                break;
            case 'aper_assessment':
                # code...
                return $this->importAperAssessment($request);
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



    public function viewEmployeesImport(Request $request)
    {
        $companies=Company::all();
        return view('import.employees',compact('companies'));
    }
    public function viewDepartmentsImport(Request $request)
    {
        $companies=Company::all();
        return view('import.departments',compact('companies'));
    }
    public function viewBranchesImport(Request $request)
    {
        $companies=Company::all();
        return view('import.branches',compact('companies'));
    }
    public function viewJobrolesImport(Request $request)
    {
        $companies=Company::all();
        return view('import.jobroles',compact('companies'));
    }
    public function viewGradesImport(Request $request)
    {
        $companies=Company::all();
        return view('import.grades',compact('companies'));
    }
    public function viewUpdateDobImport(Request $request)
    {
        $companies = Company::all();
        return view('import.update-dob', compact('companies'));
    }

    public function importEmpGrade(Request $request)
    {
        $document = $request->file('template');
        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        $company=Company::find($request->company_id);

        if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use ($company) {
                $array=$reader->toArray();
                foreach ($reader->toArray() as $key => $row) {
                    $old_user=User::where('emp_num',$row['staff_id'])->first();
                    $grade=Grade::where('level',$row['grade'])->first();
                    if ($grade && $old_user) {

                        $hist=$old_user->promotionHistories()->first();

                        if ($hist) {
                            $hist->update(['approved_by'=>Auth::user()->id,'approved_on'=>date('Y-m-d'),'old_grade_id'=>$grade->id,'grade_id'=>$grade->id]);
                            $old_user->grade_id=$grade->id;
                            $old_user->save();
                        }else{
                            $old_user->promotionHistories()->create(['approved_by'=>Auth::user()->id,'approved_on'=>date('Y-m-d'),'old_grade_id'=>$grade->id,'grade_id'=>$grade->id]);
                            $old_user->grade_id=$grade->id;
                            $old_user->save();
                        }
                    }
                }
            });


            $request->session()->flash('success', 'Import was successful!');

            return back();
        }

    }

    public function importEmployees(Request $request)
    {
        $document = $request->file('template');

        $company=Company::find(companyId());

        if($request->hasFile('template')){
            $datas = \Excel::load($request->file('template')->getrealPath(), function ($reader) {

            })->get();

            foreach($datas[0] as $row){
                $branch=Branch::where('name', 'like', '%'.$row['branch'].'%')->where('company_id',$company->id)->first();
                $gender = ($row['gender'] == 'Male') ? 'M' : ($row['gender'] == 'Female' ? 'F' : '');
                $confirmation_status = ($row['confirmation_status'] == 'Probation') ? '0' : ($row['confirmation_status'] == 'Confirmed' ? '1' : '2');
                $company_id=$company->id;
                $job=Job::where('title', 'like', '%'.$row['current_job_role'].'%')->whereHas('department',function($query) use($company_id){
                    $query->where('departments.company_id',$company_id);
                })->first();
                $grade=Grade::where('level',$row['grade'])->first();
                $bank=Bank::where('bank_name', 'like', '%'.$row['bank'].'%')->first();
                $old_user=User::where('emp_num',$row['staffid'])->first();

                if (!$old_user) {

                    $user=User::create(['name'=>$row['firstname'].' '.$row['lastname'],'email'=>$row['email'],'phone'=>$row['phone'],'emp_num'=>$row['staffid'],'sex'=>$gender,
                        'address'=>$row['address'],'marital_status'=>$row['marital_status'],'dob'=>$row['date_of_birth'],'branch_id'=>($branch ?$branch->id : 0),
                        'grade_id'=>($grade ?$grade->id : 0),
                        'bank_id'=>($bank ?$bank->id : 0),'job_id'=>($job ?$job->id : 0),'status'=>$confirmation_status,'bank_account_no'=>$row['account_number'],
                        'company_id'=>$company->id,'hiredate'=>$row['hiredate'],'confirmation_date'=>$row['date_confirmed'],'role_id'=>4]);
                    $user->notify(new NewUserCreatedNotify($user));
                    $user_temp=\App\UserTemp::updateOrCreate(['user_id'=>$user->id],$user->toArray());
                    if ($row['next_of_kin']!='' && $row['relationship']!='') {

                        $nok=\App\Nok::create(['name'=>$row['next_of_kin'],'phone'=>$row['phone_of_next_of_kin'],'address'=>$row['address_of_next_of_kin'],'relationship'=>strtolower($row['relationship']),'user_id'=>$user->id]);
                    }

                    if ($grade) {

                        $user->promotionHistories()->create(['approved_by'=>Auth::user()->id,'approved_on'=>date('Y-m-d'),'old_grade_id'=>$grade->id,'grade_id'=>$grade->id]);
                    }
                    if($job){
                        $user->jobs()->attach($job->id,['started'=>date('Y-m-d')]);
                    }
                }else{
                    $old_user->update(['name'=>$row['firstname'].' '.$row['lastname'],'email'=>$row['email'],'phone'=>$row['phone'],'sex'=>$gender,
                        'address'=>$row['address'],'marital_status'=>$row['marital_status'],'dob'=>$row['date_of_birth'],'branch_id'=>($branch ?$branch->id : 0),

                        'bank_id'=>($bank ?$bank->id : 0),'status'=>$confirmation_status,'bank_account_no'=>$row['account_number'],
                        'company_id'=>$company->id,'hiredate'=>$row['hiredate'],'confirmation_date'=>$row['date_confirmed']]);


                    if ($row['next_of_kin']!='' && $row['relationship']!='') {

                        \App\Nok::updateOrCreate(
                            ['user_id' => $old_user->id],
                            ['name'=>$row['next_of_kin'],'phone'=>$row['phone_of_next_of_kin'],'address'=>$row['address_of_next_of_kin'],'relationship'=>strtolower($row['relationship']),'user_id'=>$old_user->id]
                        );


                    }

                }


            }


//          $request->session()->flash('success', 'Import was successful!');

            return 'success';
        }


    }
    public function importUsers(Request $request)
    {
        ini_set('max_execution_time', '300');
        $document = $request->file('template');
        $company=Company::find(companyId());
        if($request->hasFile('template')){
            $datas = \Excel::load($request->file('template')->getrealPath(), function ($reader) {

            })->get();
            $errors=[];
            //return $datas;
            foreach($datas as $row){
                //$user=User::where('emp_num',$row['empnum'])->first();
                User::where('emp_num',$row['empnum'])->update(['last_promoted'=>$row['present']]);
                /*if (!$user) {
                    try{
                        $user=User::create(['id'=>$row['id'],'name'=>$row['name'],'email'=>$row['email'],'phone'=>$row['phone'],'emp_num'=>$row['emp_num'],'gender'=>$row['gender'],
                            'address'=>$row['address'],'marital_status'=>$row['marital_status'],'dob'=>$row['dob'],
                            'grade_id'=>$row['grade_id'] >0 ? $row['grade_id']  :0,'pension_fund_administrator_id'=>$row['pension_fund_administrator_id']>0 ? $row['pension_fund_administrator_id']:0,
                            'pension_account_no'=>$row['pension_account_no'],'last_promoted'=>$row['last_promoted'],
                            'rank_id'=>$row['rank_id']>0 ? $row['rank_id'] :0,'cadre_id'=>$row['cadre_id']>0 ?$row['cadre_id'] : 0,
                            'field_office_id'=>$row['field_office_id']>0 ? $row['field_office_id'] :0,'line_manager_id'=>$row['line_manager_id']>0 ? $row['line_manager_id']:0,
                            'bank_id'=>0,'job_id'=> 0,'status'=>1,'bank_account_no'=>$row['bank_account_no'],
                            'company_id'=>8,'hiredate'=>date('Y-m-d',strtotime($row['hiredate'])),'confirmation_date'=>date('Y-m-d',strtotime($row['confirmation_date'])),'role_id'=>4]);

                    }catch(\Exception $e){
                        $errors[]=[$row,$e];
                    }

                }else{
                    try{
                        $user->update(['id'=>$row['id'],'name'=>$row['name'],'email'=>$row['email'],'phone'=>$row['phone'],'gender'=>$row['gender'],
                            'address'=>$row['address'],'marital_status'=>$row['marital_status'],'dob'=>$row['dob'],
                            'grade_id'=>$row['grade_id'],'pension_fund_administrator_id'=>$row['pension_fund_administrator_id']>0 ? $row['pension_fund_administrator_id']:0,
                            'pension_account_no'=>$row['pension_account_no'],'last_promoted'=>$row['last_promoted'],
                            'rank_id'=>$row['rank_id']>0 ? $row['rank_id'] :0,'cadre_id'=>$row['cadre_id']>0 ?$row['cadre_id'] : 0 ,
                            'field_office_id'=>$row['field_office_id']>0 ? $row['field_office_id'] : 0,'line_manager_id'=>$row['line_manager_id'],
                            'bank_id'=>0,'job_id'=> 0,'status'=>1,'bank_account_no'=>$row['bank_account_no'],
                            'company_id'=>8,'hiredate'=>date('Y-m-d',strtotime($row['hiredate'])),'confirmation_date'=>date('Y-m-d',strtotime($row['confirmation_date'])),'role_id'=>4]);
                    }catch(\Exception $e){
                        $errors[]=[$row,$e];
                    }

                }*/
            }

            return ['success',$errors];
//          $request->session()->flash('success', 'Import was successful!');

//        return back();
        }


    }
    public function importDepartments(Request $request)
    {
        $document = $request->file('template');
        $company=Company::find(companyId());
        if($request->hasFile('template')){
            $datas = \Excel::load($request->file('template')->getrealPath(), function ($reader) {

            })->get();

            foreach($datas as $row){
                $dept=Department::where('name',$row['name'])->first();
                if (!$dept) {
                    Department::create(['name'=>$row['name'],'company_id'=>$company->id]);
                }
            }

            return 'success';
//          $request->session()->flash('success', 'Import was successful!');

//        return back();
        }


    }


    public function importBranches(Request $request)
    {
        $document = $request->file('template');
        $company=Company::find(companyId());


        if($request->hasFile('template')){
            $datas = \Excel::load($request->file('template')->getrealPath(), function ($reader) {
            })->get();

            foreach($datas as $row){
                $branch=Branch::where('name',$row['branch_name'])->first();
                if (!$branch) {
                    Branch::create(['name'=>$row['branch_name'],'company_id'=>$company->id,'address'=>$row['branch_address'],'email'=>$row['branch_email']]);
                }
            }

            return 'success';
//          $request->session()->flash('success', 'Import was successful!');

//        return back();
        }


    }

    public function ImportAperAssessmentDetails(Request $request)
    {
        ini_set('max_execution_time', '300');
        DB::table('performance_assessments')->orderBy('id')->chunk(1000, function ($assessment_details) {
            foreach ($assessment_details as $detail) {
                if ($detail->fiscal_year > 0)
                {
                    $measurement_period = \App\AperMeasurementPeriod::whereYear('from', $detail->fiscal_year)->first();
                    if (!$measurement_period) {
                        $measurement_period = AperMeasurementPeriod::create(['from' => date('Y-m-d', strtotime('01-01-' . $detail->fiscal_year)), 'to' => date('Y-m-d', strtotime('31-12-' . $detail->fiscal_year))]);
                    }
                    $assessment=$aper_assessment= \App\AperAssessment::where(['employee_id'=>$detail->user_id,'aper_measurement_period_id'=>$measurement_period->id])->first();
                    if(!$assessment){

                        $assessment=\App\AperAssessment::create(['aper_measurement_period_id'=>$measurement_period->id,'company_id'=>companyId(),
                            'employee_id'=>$detail->user_id,'manager_id'=>$detail->created_by,
                            'score'=>0]);

                    }
                    \App\AperAssessmentDetail::updateOrCreate(['user_id'=>$detail->user_id,'aper_assessment_id'=>$assessment->id,
                        'aper_sub_metric_id'=>$detail->performance_module_id],
                        ['user_id'=>$detail->user_id,'aper_assessment_id'=>$assessment->id,'aper_sub_metric_id'=>$detail->performance_module_id,
                            'created_by'=>$detail->created_by,'updated_by'=>$detail->created_by,'score'=>$detail->score]);

                }


            }
        });
        return 'success';
    }
    public function importAperAssessment(Request $request)
    {
        ini_set('max_execution_time', '300');
        $document = $request->file('template');
        $company=Company::find(companyId());


        if($request->hasFile('template')){
            $datas = \Excel::load($request->file('template')->getrealPath(), function ($reader) {
            })->get();

            foreach($datas as $row){
                $measurement_period=\App\AperMeasurementPeriod::whereYear('from',$row['year'])->first();
                if(!$measurement_period){
                    $measurement_period=AperMeasurementPeriod::create(['from'=>date('Y-m-d',strtotime('01-01-'.$row['year'])),
                        'to'=>date('Y-m-d',strtotime('31-12-'.$row['year']))]);
                }
                $aper_assessment= \App\AperAssessment::where(['employee_id'=>$row['employee_id'],
                    'aper_measurement_period_id'=>$measurement_period->id])->first();

                if (!$aper_assessment) {
                    \App\AperAssessment::create(['aper_measurement_period_id'=>$measurement_period->id,
                        'company_id'=>$company->id,
                        'employee_id'=>$row['employee_id'],
                        'manager_id'=>$row['manager_id'],
                        'created_by'=>$row['manager_id'],
                        'updated_by'=>$row['manager_id'],
                        'manager_approved'=>$row['manager_approved'],'employee_approved'=>$row['employee_approved']
                        ,'manager_approved_date'=>$row['manager_approved_date'],'employee_approved_date'=>$row['employee_approved_date'],
                        'manager_comment'=>$row['manager_comment'],
                        'score'=>$row['score'],'employee_comment'=>$row['employee_comment']]);
                }
            }

            return 'success';
//          $request->session()->flash('success', 'Import was successful!');

//        return back();
        }


    }

    public function importJobroles(Request $request)
    {
        $document = $request->file('template');
        $company=Company::find($request->company_id);


        if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {

                foreach ($reader->toArray() as $key => $row) {
                    $department=Department::where(['name'=>$row['department_name'],'company_id'=>$company->id])->first();
                    if ($department) {
                        $job=Job::where(['title'=>$row['title'],'department_id'=>$department->id])->first();
                        if (!$job) {
                            $qualification=\App\Qualification::find($row['qua_id']);
                            Job::create(['title'=>$row['title'],'department_id'=>$department->id,'description'=>$row['description'],'qualification_id'=>$qualification->id]);
                        }elseif($job){
                            $reports_to=$company->jobs()->where(['title'=>$row['reports_to']])->first();
                            if ($reports_to) {
                                $job->update(['description'=>$row['description'],'parent_id'=>$reports_to->id]);
                            }

                        }

                    }

                }
            });

            $request->session()->flash('success', 'Import was successful!');

            return back();
        }

    }

    public function importUserRoles(Request $request)
    {
        $document = $request->file('template');
        $company=Company::find($request->company_id);
        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        if($request->hasFile('template')){
            Excel::load($request->file('template')->getRealPath(), function ($reader) use($company) {

                foreach ($reader->toArray() as $key => $row) {
                    // $hiredate=\Carbon\Carbon::createFromFormat('d/m/Y', $row['hiredate'])->toDateTimeString();
                    if ($row['jobid']) {
                        $job=\App\Job::find($row['jobid']);
                        $user=\App\User::where(['emp_num'=>$row['staff_id']])->first();
                        $user->jobs()->attach($job->id);
                        $user->job_id=$job->id;
                        $user->department_id=$job->department->id;
                        $user->save();
                    }


                }
            });

            $request->session()->flash('success', 'Import was successful!');

            return back();
        }

    }

    public function importGrades(Request $request)
    {
        // $document = $request->file('template');
        $company=Company::find(companyId());
        if($request->hasFile('template')){
            $datas = \Excel::load($request->file('template')->getrealPath(), function ($reader) {
            })->get();

            foreach($datas as $row){
                $grade=Grade::where('level',$row['level'])->where('company_id',$company->id)->first();
                if (!$grade) {
                    Grade::create(['level'=>$row['level'],'leave_length'=>$row['leave_length'],'basic_pay'=>$row['monthly_gross'],'company_id'=>$company->id]);
                }else{
                    $grade->update(['level'=>$row['level'],'leave_length'=>$row['leave_length'],'basic_pay'=>$row['monthly_gross']]);
                }
            }

            return 'success';

        }

    }
    public function importDependants(Request $request)
    {
        // $document = $request->file('template');
        $company=Company::find(companyId());
        if($request->hasFile('template')){
            $datas = \Excel::load($request->file('template')->getrealPath(), function ($reader) {
            })->get();

            foreach($datas[0] as $row){
                $dependant=Dependant::where('name',$row['name'])->where('empnum',$row['employee_id'])->first();
                if (!$dependant) {
                    Dependant::create(['name'=>$row['name'],'user_id'=>$row['employee_id'],'email'=>$row['email'],'phone'=>$row['phone'],
                        'dob'=>$row['date_of_birth'],'relationship'=>$row['relationship'],'company_id'=>$company->id]);
                }
            }

            return 'success';

        }

    }
    public function importDob(Request $request)
    {
        $document = $request->file('template');
        $company = Company::find($request->company_id);
        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        if ($request->hasFile('template')) {
            Excel::load($request->file('template')->getRealPath(), function ($reader) use ($company) {

                foreach ($reader->toArray() as $key => $row) {

                    if ($row['staff_id']) {
                        // $dob = \Carbon\Carbon::createFromFormat('Y-m-d',$row['dob'])->format('Y-m-d');
                        // $hiredate = \Carbon\Carbon::createFromFormat('Y-m-d', $row['hiredate'])->format('Y-m-d');
                        $user = \App\User::where(['emp_num' => $row['staff_id']])->first();
                        if($user){
                            try{
                                $user->email = $row['email'];
                                // $user->hiredate = $row['hiredate'];
                                $user->save();
                            }catch(\Exception $e){
                                return 'error';
                            }
                        }


                    }
                }
            });

            $request->session()->flash('success', 'Import was successful!');

            return 'success';
        }
    }

    public function downloadEmployeeUploadTemplate(Request $request){
        $first_row = [
            ['StaffID'=>'','FirstName'=>'', 'LastName'=>'','Email'=>'','Gender'=>''
                ,'Date of Birth'=>'','Phone'=>'','Marital Status'=>'','Address'=>'','Hiredate'=>'','Confirmation Status'=>''
                ,'Date confirmed'=>'','Branch'=>'','Current Job Role'=>'','Grade'=>'','Bank'=>''
                ,'Account Number'=>'','Next of Kin'=>'','Relationship'=>'','Phone of Next of Kin'=>'','Address of Next of Kin'=>'']
        ];
        $company_id=companyId();
        $branches = Branch::where('company_id',companyId())->select('company_id','name')->get()->toArray();
        $job_roles = Job::select('id','title')->whereHas('department',function($query) use($company_id){
            $query->where('departments.company_id',$company_id);
        })->get()->toArray();
        $banks = Bank::select('id','bank_name as name')->get()->toArray();
        $grades = Grade::select('id','level')->get()->toArray();

        $marital_status = [['option' => 'single', 'value' => 'Single'], ['option' => 'married', 'value' => 'Married'], ['option' => 'divorced', 'value' => 'Divorced'],['option' => 'separated', 'value' => 'Separated']];
        $gender=[['option' => 'M', 'value' => 'Male'], ['option' => 'F', 'value' => 'Female']];
        $confirmation_status=[['option' => '1', 'value' => 'Confirmed'], ['option' => '0', 'value' => 'Probation']];
        $relationship = [['option' => 'spouse', 'value' => 'spouse'], ['option' => 'mother', 'value' => 'mother'], ['option' => 'father', 'value' => 'father'],['option' => 'son', 'value' => 'son']
            ,['option' => 'daughter', 'value' => 'daughter'],['option' => 'brother', 'value' => 'brother'],['option' => 'sister', 'value' => 'sister'],['option' => 'nephew', 'value' => 'nephew'],['option' => 'niece', 'value' => 'niece']
            ,['option' => 'uncle', 'value' => 'uncle'],['option' => 'aunt', 'value' => 'aunt'],['option' => 'friend', 'value' => 'friend']];
        return $this->exportToExcelDropDown('Employee Upload Template',
            ['Employee Details' => [$first_row, ''],'relationship' => [$relationship, 'S'],'gender' => [$gender, 'E'],'marital_status' => [$marital_status, 'H'],'confirmation_status' => [$confirmation_status, 'K'],'job_roles' => [$job_roles, 'N'],'banks' => [$banks, 'P'],'grades' => [$grades, 'O'],'branches' => [$branches, 'M', 'branches']]
        );
    }
    public function downloadJobRolesTemplate(Request $request){
        $first_row = [
            ['Title'=>'','Department'=>'', 'Qualification'=>'','Description'=>'']
        ];

        $departments = Department::select('id','name')->where('company_id',companyId())->get()->toArray();
        $qualifications = Qualification::select('id','name')->get()->toArray();

        return $this->exportToExcelDropDown('Job Roles Template',
            ['Job Roles' => [$first_row, ''],'departments' => [$departments, 'B'],'qualifications' => [$qualifications, 'C','qualifications']]
        );
    }
    public function downloadAcademicQualificationTemplate(Request $request){
        $first_row = [
            ['Employee ID'=>'','Title'=>'', 'Qualification'=>'','Year'=>'','Institution'=>'','Class'=>'','Discipline'=>'']
        ];
        $users = User::where('company_id',companyId())->where('status','!=','2')->select('name','emp_num','company_id')->get();
        $users=$users->map(function ($name) {
            return ['name'=>$name->name,'emp_num'=>$name->emp_num];
        });

        $qualifications = Qualification::select('id','name')->get()->toArray();

        return $this->exportToExcelDropDown('Employee Academic Qualification Template',
            ['Job Roles' => [$first_row, ''],'users' => [$users, 'A'],'qualifications' => [$qualifications, 'C','qualifications']]
        );
    }
    public function downloadWorkExperienceTemplate(Request $request){
        $first_row = [
            ['Employee ID'=>'','Organization'=>'', 'Position'=>'','StartDate'=>'','EndDate'=>'']
        ];
        $users = User::where('company_id',companyId())->where('status','!=','2')->select('name','emp_num','company_id')->get();
        $users=$users->map(function ($name) {
            return ['name'=>$name->name,'emp_num'=>$name->emp_num];
        });



        return $this->exportToExcelDropDown('Work Experience Template',
            ['Work Experience' => [$first_row, ''],'users' => [$users, 'A', 'users']]
        );
    }
    public function downloadDependentTemplate(Request $request){
        $first_row = [
            ['Employee ID'=>'','Name'=>'', 'Date of Birth'=>'','Email'=>'','Phone'=>'','Relationship'=>'']
        ];
        $users = User::where('company_id',companyId())->where('status','!=','2')->select('name','emp_num','company_id')->get();
        $users=$users->map(function ($name) {
            return ['name'=>$name->name,'emp_num'=>$name->emp_num];
        });
        $relationship = [['option' => 'spouse', 'value' => 'spouse'], ['option' => 'mother', 'value' => 'mother'], ['option' => 'father', 'value' => 'father'],['option' => 'son', 'value' => 'son']
            ,['option' => 'daughter', 'value' => 'daughter'],['option' => 'brother', 'value' => 'brother'],['option' => 'sister', 'value' => 'sister'],['option' => 'nephew', 'value' => 'nephew'],['option' => 'niece', 'value' => 'niece']
            ,['option' => 'uncle', 'value' => 'uncle'],['option' => 'aunt', 'value' => 'aunt'],['option' => 'friend', 'value' => 'friend']];

        return $this->exportToExcelDropDown('Dependent Template',
            ['Employee Dependant' => [$first_row, ''],'relationship'=>[$relationship,'F'],'users' => [$users, 'A', 'users']]
        );
    }
    public function downloadGradeTemplate(Request $request){
        $first_row = [
            ['Level'=>'','Leave Length'=>'', 'Monthly Gross'=>'','Description'=>'']
        ];


        return $this->exportToExcelDropDown('Grades Template',
            ['Grades' => [$first_row, '']]
        );
    }
    public function downloadBranchTemplate(Request $request){

        $first_row = [
            ['Branch Name'=>'','Branch Address'=>'','Branch Email'=>'']
        ];


        return $this->exportToExcelDropDown('Branch Template',
            ['Branches' => [$first_row, '']]
        );
    }
    public function downloadDepartmentTemplate(Request $request){
        $first_row = [
            ['Name'=>'']
        ];


        return $this->exportToExcelDropDown('Department Template',
            ['Departments' => [$first_row, '']]
        );
    }

    private function exportToExcelDropDown($worksheetname, $data)
    {

        return \Excel::create($worksheetname, function ($excel) use ($data) {

            foreach ($data as $sheetname => $realdata) {
                $excel->sheet($sheetname, function ($sheet) use ($realdata, $sheetname, $data) {
                    $last = collect($data)->last();
                    $sheet->fromArray($realdata[0]);
                    if(count($data)>1){
                        if ($sheetname == $last[2]) {

                            $i = 1;
                            foreach ($data as $key => $data) {
                                $Cell = $data[1];
                                if ($data[1] != '') {

                                    $sheet->_parent->addNamedRange(
                                        new \PHPExcel_NamedRange(
                                            "sd{$data[1]}", $sheet->_parent->getSheet($i), "B2:B" . $sheet->_parent->getSheet($i)->getHighestRow()
                                        )
                                    );
                                    $i++;
                                    for ($j = 2; $j <= 500; $j++) {

                                        $objValidation = $sheet->_parent->getSheet(0)->getCell("{$data[1]}$j")->getDataValidation();
                                        $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                                        $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                                        $objValidation->setAllowBlank(false);
                                        $objValidation->setShowInputMessage(true);
                                        $objValidation->setShowErrorMessage(true);
                                        $objValidation->setShowDropDown(true);
                                        $objValidation->setErrorTitle('Input error');
                                        $objValidation->setError('Value is not in list.');
                                        $objValidation->setPromptTitle('Pick from list');
                                        // $objValidation->setPrompt('Please pick a value from the drop-down list.');
                                        $objValidation->setFormula1("sd{$data[1]}");

                                    }
                                }
                            }
                        }
                    }
                });

            }
        })->download('xlsx');
    }



}
