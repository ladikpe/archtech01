<?php

namespace App\Http\Controllers;

use App\Cadre;
use App\MedicalHistory;
use App\Notifications\ApproveNokChange;
use App\Notifications\ApproveProfileChange;
use App\Notifications\NewUserCreatedNotify;
use App\PensionFundAdministrator;
use App\Rank;
use App\Repositories\QueryRepository;
use App\Traits\FaceMatchTrait;
use App\User;
use App\UserTemp;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Filters\UserFilter;
use App\Company;
use App\Job;
use App\Department;
use App\Location;
use App\StaffCategory;
use App\Position;
use Validator;
use App\Role;
use App\Qualification;
use App\UserGroup;
use App\Competency;
use App\Bank;
use App\Grade;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');

        $this->middleware('permission:edit_user_advanced')->only('edit');

        // $this->middleware('subscribed')->except(['index','search']);
    }

    public function index(Request $request)
    {
        $query_types = \App\Query::select('title', 'id', 'content')->where('company_id', companyId())->get();
        $auth = Auth::user();
        $company_id = companyId();

        if (Auth::user()->role->manages == 'all') {
            $usersforcount = User::where('company_id', '=', $company_id)->get();
        } elseif (Auth::User()->role->manages == "dr") {
            $usersforcount = Auth::User()->employees()->get();
        }
        $roles = Role::all();
        $competencies = Competency::all();
        $user_groups = UserGroup::all();

        $managers = User::whereHas('role', function ($query) {
            $query->where('manages', 'dr');
            $query->orWhere('manages', 'all');
        })->get();
        $staff_categories = StaffCategory::all();
        $grades = Grade::all();
        $cadres=Cadre::all();
        $zones=Zone::all();


        if (count($request->all()) == 0) {
            if ($company_id > 0) {
                if (Auth::user()->role->manages == 'all') {
                    $users = User::where('company_id', '=', $company_id)->whereIn('status', [0, 1])->orderByDesc('created_at')->paginate(10);
                } elseif (Auth::User()->role->manages == "dr") {
                    $users = Auth::User()->employees()->orderByDesc('created_at')->paginate(10);
                }


            } else {
                $users = User::where('rank.grade',function($query){
                    $query->orderBy('position','desc');
                })->paginate(10);
            }
            $ncompany = Company::find($company_id);

            $companies = Company::all();
            $branches = $companies->first()->branches;
            $departments = $companies->first()->departments;
            $divisions=$departments->first()->divisions;
            $qualifications = Qualification::all();
            return view('empmgt.list', ['query_types' => $query_types, 'users' => $users, 'usersforcount' => $usersforcount, 'companies' => $companies, 'branches' => $branches, 'departments' => $departments, 'roles' => $roles, 'user_groups' => $user_groups, 'managers' => $managers, 'qualifications' => $qualifications, 'competencies' => $competencies, 'ncompany' => $ncompany, 'grades' => $grades, 'staff_categories' => $staff_categories,'cadres'=>$cadres,'zones'=>$zones,'divisions'=>$divisions]);

        } else {
            $users = UserFilter::apply($request);
            $companies = Company::all();
            $ncompany = Company::find($company_id);

            $branches = $companies->first()->branches;
            $departments = $companies->first()->departments;
             $divisions=$departments->first()->divisions;


            if ($request->excel == true) {

                    return $this->exportAllUsersToExcel($company_id,$users);
                # code...
            }
            if ($request->excelall == true) {
                $users = User::where('company_id', '=', $company_id)->get();
                 return $this->exportAllUsersToExcel($company_id,$users);
                # code...
            }

            return view('empmgt.list', ['query_types' => $query_types, 'users' => $users, 'usersforcount' => $usersforcount, 'companies' => $companies, 'branches' => $branches, 'departments' => $departments, 'roles' => $roles, 'user_groups' => $user_groups, 'managers' => $managers, 'competencies' => $competencies, 'ncompany' => $ncompany, 'grades' => $grades, 'staff_categories' => $staff_categories,'cadres'=>$cadres,'zones'=>$zones,'divisions'=>$divisions]);

        }

    }


    public function exportAllUsersToExcel($company_id,$users){
        $view = 'empmgt.list-excel';

        // return view('compensation.d365payroll',compact('payroll','allowances','deductions','income_tax','salary','date','has_been_run'));
        return \Excel::create("export", function ($excel) use ($users, $view) {

            $excel->sheet("export", function ($sheet) use ($users, $view) {
                $sheet->loadView("$view", compact('users'))
                    ->setOrientation('landscape');
            });

        })->export('xlsx');


    }


    public function getCompanyDepartmentsBranches($company_id)
    {
        $company = Company::find($company_id);
        return ['departments' => $company->departments, 'branches' => $company->branches];
    }

    public function getDepartmentJobroles($department_id)
    {
        $department = Department::find($department_id);
        return ['jobroles' => $department->jobs];
    }

    public function getCadreRanks($cadre_id)
    {
        $cadre = Cadre::find($cadre_id);
        return ['ranks' => $cadre->ranks];
    }
    public function getZoneFieldOffices($zone_id)
    {
        $zone = Zone::find($zone_id);
        return ['field_offices' => $zone->field_offices];
    }
    public function getDepartmentDivisions($department_id)
    {
        $department = Department::find($department_id);
        return ['divisions' => $department->divisions];
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

    public function assignRole(Request $request)
    {
        // return $request->users;
        $users_count = is_array($request->users);
        $role_id = $request->role_id;

        for ($i = 0; $i < $users_count; $i++) {
            $user = User::find($request->users[$i]);
            $user->role_id = $role_id;
            $user->save();
        }
        return 'success';
    }

    public function alterStatus(Request $request)
    {
        // return $request->users;
        $users_count = count($request->users);
        $status = $request->status;

        for ($i = 0; $i < $users_count; $i++) {
            $user = User::find($request->users[$i]);
            $user->status = $status;
            $user->save();
        }
        return 'success';
    }

    public function alterEmployeeStatus(Request $request)
    {
        // return $request->users;
        $users_count = count($request->users);
        $status = $request->status;

        for ($i = 0; $i < $users_count; $i++) {
            $user = User::find($request->users[$i]);
            $user->employment_status = $status;
            $user->save();
        }
        return 'success';
    }

    public function alterLoginStatus(Request $request)
    {
        // return $request->users;
        $users_count = count($request->users);
        $status = $request->status;

        for ($i = 0; $i < $users_count; $i++) {
            $user = User::find($request->users[$i]);
            $user->active = $status;
            $user->save();
        }
        return 'success';
    }

    public function assignManager(Request $request)
    {
        // return $request->users;
        $users_count = count($request->users);
        $manager_id = $request->manager_id;
        $manager = User::find($manager_id);

        for ($i = 0; $i < $users_count; $i++) {
            $user = User::find($request->users[$i]);
            $has_manager = $user->managers->contains('id', $manager_id);
            // $user->line_manager_id = $manager_id;
            // $user->save();
            // $has_manager=User::find($request->users[$i])->whereHas('managers',function ($query) use($manager_id)  {
            //      $query->where('users.id',$manager_id);
            //  })->get();
            if (!$has_manager && $manager_id != $request->users[$i]) {
                $user->managers()->attach($manager_id);
                $user->line_manager_id = $manager_id;
                $user->save();
            }
        }
        return 'success';
    }

    public function assignGroup(Request $request)
    {
        // return $request->users;
        $users_count = count($request->users);
        $group_id = $request->group_id;
        $group = UserGroup::find($group_id);

        for ($i = 0; $i < $users_count; $i++) {
            $user = User::find($request->users[$i]);
            $has_group = $user->user_groups->contains('id', $group_id);
            // $has_manager=User::find($request->users[$i])->whereHas('managers',function ($query) use($manager_id)  {
            //      $query->where('users.id',$manager_id);
            //  })->get();
            if (!$has_group) {
                $user->user_groups()->attach($group_id);
            }
        }
        return 'success';
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), ['name' => 'required|min:3', 'emp_num' => ['required',
            Rule::unique('users')->ignore($request->user_id)
        ]]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 401);
        }
        //build LGA
        // $lga=\App\LocalGovernment::find($request->lga);
        // if (!$lga and $request->lga!='') {
        //     $lga=\App\LocalGovernment::create(['name'=>$request->lga,'state_id'=>$request->state]);
        // }
        //end build LGA
        $user = User::find($request->user_id);
        $rank=Rank::find($request->rank_id);
        if (Auth::user()->role->permissions->contains('constant', 'manage_user')) {

            $user->update(['name' => $request->name, 'email' => $request->email, 'hiredate' => date('Y-m-d', strtotime($request->hiredate)), 'phone' => $request->phone, 'emp_num' => $request->emp_num, 'sex' => $request->sex, 'address' => $request->address, 'marital_status' => $request->marital_status, 'dob' => date('Y-m-d', strtotime($request->dob)), 'bank_id' => $request->bank_id, 'bank_account_no' => $request->bank_account_no, 'country_id' => $request->country, 'state_id' => $request->state, 'lga_id' => $request->lga, 'payroll_type' => $request->payroll_type, 'project_salary_category_id' => $request->project_salary_category, 'expat' => $request->expat, 'confirmation_date' => date('Y-m-d', strtotime($request->confirmation_date)),'pension_fund_administrator_id'=>$request->pension_fund_administrator_id,'pension_account_no'=>$request->pension_account_no,'cadre_id'=>$request->cadre_id,'rank_id'=>$request->rank_id,'field_office_id'=>$request->field_office_id,'date_of_present_appointment'=>$request->date_of_present_appointment,'department_id'=>$request->department_id,'division_id'=>$request->division_id]);

            if ($request->filled('nok_name')) {
                $nok = \App\Nok::updateOrCreate(['id' => $request->nok_id], ['name' => $request->nok_name, 'phone' => $request->nok_phone, 'address' => $request->nok_address, 'relationship' => $request->nok_relationship, 'user_id' => $request->user_id]);
            }


            if ($request->file('avatar')) {
                $path = $request->file('avatar')->store('avatar');
                if (Str::contains($path, 'avatar')) {
                    $filepath = Str::replaceFirst('avatar', '', $path);
                } else {
                    $filepath = $path;
                }
                $user->image = $filepath;
                $user->save();

                $url = asset('uploads/public/avatar' . $filepath);
                $url = 'http://enyo.thehcmatrix.com/uploads/verify/uQTgGhJvd3UiB6yuSWLLHCvzq2vrXlG9xIjqHHLq.png';
                $urls = [$url];
                $image_id = $this->addFacetoList($urls);
                $user->image_id = $image_id[$url];
                $user->save();

            }
        } else {
            $user = UserTemp::find($request->user_id);
            $old_user = User::find($request->user_id);
            if (companyId() == 8) {
                $hrs = User::whereHas('role.permissions', function ($query) {
                    $query->where('constant', 'manage_user');
                })->where('company_id', 8)->get();
            } elseif (companyId() == 9) {
                $hrs = User::whereHas('role.permissions', function ($query) {
                    $query->where('constant', 'manage_user');
                })->where('company_id', 9)->get();
            } else {
                $hrs = User::whereHas('role.permissions', function ($query) {
                    $query->where('constant', 'manage_user');
                })->where('company_id', '!=', 8)->where('company_id', '!=', 9)->get();
            }
            $user = \App\UserTemp::where('user_id', $request->user_id)->first();
            $user->update($old_user->toArray());
            $user->update(['name' => $request->name, 'email' => $request->email, 'hiredate' => date('Y-m-d', strtotime($request->hiredate)), 'phone' => $request->phone, 'emp_num' => $request->emp_num, 'sex' => $request->sex, 'address' => $request->address, 'marital_status' => $request->marital_status, 'dob' => date('Y-m-d', strtotime($request->dob)), 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'bank_id' => $request->bank_id, 'bank_account_no' => $request->bank_account_no, 'country_id' => $request->country, 'state_id' => $request->state, 'lga_id' => $request->lga, 'payroll_type' => $request->payroll_type, 'project_salary_category_id' => $request->project_salary_category, 'expat' => $request->expat, 'confirmation_date' => date('Y-m-d', strtotime($request->confirmation_date)), 'last_change_approved' => 0,'pension_fund_administrator_id'=>$request->pension_fund_administrator_id,'date_of_present_appointment'=>$request->date_of_present_appointment,'department_id'=>$request->department_id,'division_id'=>$request->division_id]);
//           $user=\App\UserTemp::updateOrCreate(['user_id'=>$request->user_id],$old_user->toArray());
//           $user=\App\UserTemp::updateOrCreate(['user_id'=>$request->user_id],['name' => $request->name, 'email' => $request->email, 'hiredate' => date('Y-m-d', strtotime($request->hiredate)), 'phone' => $request->phone, 'emp_num' => $request->emp_num, 'sex' => $request->sex, 'address' => $request->address, 'marital_status' => $request->marital_status, 'dob' => date('Y-m-d', strtotime($request->dob)), 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'bank_id' => $request->bank_id, 'bank_account_no' => $request->bank_account_no, 'country_id' => $request->country, 'state_id' => $request->state, 'lga_id' => $request->lga, 'payroll_type' => $request->payroll_type, 'project_salary_category_id' => $request->project_salary_category, 'expat' => $request->expat, 'confirmation_date' => date('Y-m-d', strtotime($request->confirmation_date)),'last_change_approved'=>0]);
            if ($old_user->nok && $old_user->nok_temp) {
                if ($old_user->nok->name != $request->nok_name || $old_user->nok->phone != $request->nok_phone || $old_user->nok->address != $request->nok_address || $old_user->nok->relationship != $request->nok_relationship) {

                    $nok = \App\Nok::where('user_id', $old_user->id)->first()->toArray();
                    $old_user->nok_temp->update($nok);
                    $old_user->nok_temp->update(['name' => $request->nok_name, 'phone' => $request->nok_phone, 'address' => $request->nok_address, 'relationship' => $request->nok_relationship, 'user_id' => $request->user_id, 'last_change_approved' => 0]);
                    foreach ($hrs as $hr) {
                        $hr->notify(new ApproveNokChange($old_user));
                    }
                }
            } else {
                if ($request->filled('nok_name')) {
                    $nok = \App\NokTemp::updateOrCreate(['user_id' => $request->user_id], ['name' => $request->nok_name, 'phone' => $request->nok_phone, 'address' => $request->nok_address, 'relationship' => $request->nok_relationship, 'user_id' => $request->user_id, 'last_change_approved' => 0]);

                    foreach ($hrs as $hr) {
                        $hr->notify(new ApproveNokChange($old_user));
                    }
                }
            }


            if ($request->file('avatar')) {
                $path = $request->file('avatar')->store('avatar');
                if (Str::contains($path, 'avatar')) {
                    $filepath = Str::replaceFirst('avatar', '', $path);
                } else {
                    $filepath = $path;
                }
                $user->image = $filepath;
                $user->save();


                $url = asset('uploads/public/avatar' . $filepath);
                $url = 'http://enyo.thehcmatrix.com/uploads/verify/uQTgGhJvd3UiB6yuSWLLHCvzq2vrXlG9xIjqHHLq.png';
                $urls = [$url];
                $image_id = $this->addFacetoList($urls);
                $user->image_id = $image_id[$url];
                $user->save();


            }
            foreach ($hrs as $hr) {
                $hr->notify(new ApproveProfileChange($old_user));
            }

        }
    return $request->all();
        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //

    }

    public function search(Request $request)
    {


        if ($request->q == "") {
            return "";
        } else {
            $name = \App\User::where('name', 'LIKE', '%' . $request->q . '%')
                ->select('id as id', 'name as text', 'company_id')
                ->get();
        }


        return $name;

    }

    public function modal($user_id)
    {
        $user = User::find($user_id);
        return view('empmgt.partials.info', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user_id
     * @param QueryRepository $query
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id, QueryRepository $query)
    {
        $queries = $query->getQueryData('data', 1000000);
        $user = User::find($user_id);
        $countries = \App\Country::all();
        $qualifications = Qualification::all();
        $competencies = Competency::all();
        $companies = Company::all();
        $banks = Bank::all();
        $company = Company::find(session('company_id'));
        $grades = Grade::all();
        $cadres=Cadre::all();
        $zones=Zone::all();
        $pfas=PensionFundAdministrator::all();
        if (!$company) {
            $company = Company::first();
        }
        $departments = $company->departments;
        $jobroles = $company->departments()->first()->jobs;
        $staff_categories = StaffCategory::all();
        $project_salary_categories = \App\PaceSalaryCategory::where('company_id', $company->id)->get();
        // return $user->skills()->where('skills.id',1)->first()->pivot->competency;
        $medical_history = MedicalHistory::firstOrCreate(
            ['user_id' => $user_id],
            ['current_medical_conditions' => [],
                'past_medical_conditions' => [],
                'surgeries_hospitalizations' => [],
                'medications' => [],
                'medication_allergies' => [],
                'family_history' => [],
                'social_history' => [],
                'others' => []]
        );
        return view('empmgt.profile', ['queries' => $queries, 'user' => $user, 'qualifications' => $qualifications, 'countries' => $countries, 'competencies' => $competencies, 'companies' => $companies, 'banks' => $banks, 'company' => $company, 'grades' => $grades, 'departments' => $departments, 'jobs' => $jobroles, 'staff_categories' => $staff_categories, 'project_salary_categories' => $project_salary_categories, 'medical_history' => $medical_history, 'zones' => $zones,'pfas'=>$pfas,'cadres'=>$cadres]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function saveNew(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required|min:3', 'emp_num' => ['required',
            Rule::unique('users')->ignore($request->user_id)
        ], 'email' => ['required',
            Rule::unique('users')->ignore($request->email)
        ]]);
        // $validator = Validator::make($request->all(), ['name'=>'required|min:3','emp_num'=>['required',
        //     Rule::unique('users')->ignore($request->user_id)
        // ],'phone'=>['required',
        //     Rule::unique('users')->ignore($request->user_id)
        // ]]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 401);
        }
        $rank=Rank::find($request->rank_id);
        $user = User::create(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'emp_num' => $request->emp_num, 'sex' => $request->sex, 'hiredate' => date('Y-m-d', strtotime($request->started)), 'dob' => date('Y-m-d', strtotime($request->dob)), 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'job_id' => $request->rank_id, 'department_id' => $request->department_id, 'grade_id' => $rank->grade_id, 'role_id' => 4, 'payroll_type' => 'office','cadre_id'=>$request->cadre_id,'rank_id'=>$request->rank_id,'field_office_id'=>$request->field_office_id]);

        $user->notify(new NewUserCreatedNotify($user));
        $user_temp = \App\UserTemp::updateOrCreate(['user_id' => $user->id], $user->toArray());
        if ($request->filled('grade_id')) {
            $user->promotionHistories()->create([
                'old_grade_id' => $request->grade_id, 'grade_id' => $request->grade_id, 'approved_on' => date('Y-m-d'), 'approved_by' => Auth::user()->id
            ]);

            $user->save();
        }
        if ($request->filled('job_id')) {

            $user->jobs()->attach($request->job_id, ['started' => date('Y-m-d', strtotime($request->started))]);

            $user->save();
        }


        return 'success';
    }

    public function viewOrganogram(Request $request)
    {
        $company = Company::find(companyId());
        if ($company->manager) {
            return view('empmgt.organogram', compact('company'));
        } else {
            return redirect()->back()->with('error', 'Company does not have a manager');
        }

    }

    public function deptOrganogram($id, Request $request)
    {
        $department = Department::find($id);
        if ($department) {
            if ($department->manager) {
                return view('empmgt.dept-organogram', compact('department'));
            } else {
                return redirect()->back()->with('error', 'Department does not have a manager');
            }
        } else {
            return redirect()->back()->with('error', 'Department does not exist');
        }
        // return view('empmgt.dept-organogram',compact('company'));
    }

    public function teamOrganogram(Request $request)
    {
        $line_manager = User::with(['pdreports', 'employees'])->find(Auth::user()->line_manager_id);

        if ($line_manager) {
            if ($line_manager->pdreports) {
                return view('empmgt.team-organogram', compact('line_manager'));
            } else {
                return redirect()->back()->with('error', 'Team does not have a manager');
            }
        } else {
            return redirect()->back()->with('error', 'Team manager does not exist');
        }
    }

    public function myteamOrganogram(Request $request)
    {
        // return Auth::user()->plmanager;


        if (Auth::user()->pdreports) {
            return view('empmgt.myteam-organogram');
        } else {
            return redirect()->back()->with('error', 'You do not have team members');
        }


    }

    public function directReports(Request $request)
    {
        $user = User::find($request->user_id);
        return $user->pdreports()->with(['job', 'grade'])->get();
    }

    public function viewDirectory(Request $request)
    {
        if (count($request->all()) == 0) {
            $users = User::paginate(20);
        } else {
            $users = User::where(function ($query) use ($request) {
                $query->where('email', 'like', '%' . $request->q . '%')
                    ->orWhere('name', 'like', '%' . $request->q . '%')
                    ->orWhere('phone', 'like', '%' . $request->q . '%');
            })->paginate(20);

        }
        return view('empmgt.emp-dir', compact('users'));
    }

    public function oDepartments()
    {
        $company_id = companyId();
        if ($company_id == 0) {
            $departments = Department::paginate(10);
        } else {
            $departments = Department::where('company_id', $company_id)->paginate(10);
        }

        return view('empmgt.department_list', compact('departments'));
    }

    use facematchtrait;

    public function postFacesearch(Request $request)
    {
        if ($request->file('facefile')) {
            $path = $request->file('facefile')->store('verify');
            if (Str::contains($path, 'verify')) {
                $filepath = Str::replaceFirst('verify', '', $path);
            } else {
                $filepath = $path;
            }
            $url = asset('uploads/verify' . $filepath);
            $url = 'http://enyo.thehcmatrix.com/uploads/verify/uQTgGhJvd3UiB6yuSWLLHCvzq2vrXlG9xIjqHHLq.png';

            $res = $this->faceDetectandMatch($url);
            if (isset($res->error->message)) {
                throw new \Exception($res->error->message);
            }
            $newRes = [];
            foreach ($res as $response) {
                $response = (array)$response;
                $newRes[] = array_merge($response, ['user' => User::where('image_id', $response['persistedFaceId'])->with('company')->first()]);
            }
            $response_users = $newRes;
            $users = User::where('id', '<', '0')->paginate(20);
            return view('empmgt.emp-dir', compact('users', 'response_users', 'url'));
        }
    }
     public function retirementList(Request $request)
    {
      
        $status='';
        $users=\App\User::where('id','>',2);
        
        if ($request->has('status')){
            $users=$users->where('status',$request->status);
            $status=$this->resolveType($request->status);
        }

        if ($request->has('pfa_filter')){
           $users = $users->where('pension_fund_administrator_id',$request->pfa_filter); 
        }

        $users=$users->get();

         $pfas = \App\PensionFundAdministrator::all();
        
        return view('empmgt.retirement_list',compact('users','status','pfas'));
    }
    public function resolveType($type){
			switch ($type) {
				case 1:
				$status='active';
				break;
				case 2:
				$status='suspended';
				break;
				case 3:
				$status='dismissed';
				break;
				case 4:
				$status='resigned';
				break;
				case 5:
				$status='retired';
				break;
				case 6:
				$status='deceased';
				break;
				default:
				$status='N/A';

				break;

			}
			return ucfirst($status);
		}
		public function resetPassword(Request $request)
    {
        // return $request->users;
        $users_count = count($request->users);
        $status = $request->status;

        for ($i = 0; $i < $users_count; $i++) {
            $user = User::find($request->users[$i]);
            $user->password = bcrypt('Root1234');
            $user->save();
        }
        return 'success';
    }
    
    public function syncState(Request $request){
        $old_users=DB::table('users_old')->where('id','>',1433)->get();
        foreach($old_users as $old_user){
            $old_state=DB::table('old_states')->where('id',$old_user->state_origin_id)->first();
            if($old_state){
               $state=\App\State::where('name', 'like', '%'.$old_state->state.'%')->first();
            $user=User::find($old_user->id);
            if($state && $user){
                echo $user->name .' was found-'.$user->id;
                $user->update(['state_id'=>$state->id,'country_id'=>160]);
                echo '<br>';
            
            }else{
                echo $old_user->name.' was not found-'.$old_user->id;
                echo '<br>';
            } 
            }
            
            
            
        }
        
        return 'success';
        
        
    }
    public function syncGender(Request $request){
        $old_users=DB::table('users_old')->where('id','>',1618)->get();
        foreach($old_users as $old_user){
            
            $user=User::find($old_user->id);
            if( $user){
                echo $user->name .' was found-'.$user->id;
                $user->update(['sex'=>$old_user->sex]);
                echo '<br>';
            
            }else{
                echo $old_user->name.' was not found-'.$old_user->id;
                echo '<br>';
            } 
            
            
            
            
        }
        
        return 'success';
        
        
    }
    public function syncLastPromoted(Request $request){
        $old_users=DB::table('users_old')->where('id','>',1452)->get();
        foreach($old_users as $old_user){
            
            $user=User::find($old_user->id);
            if( $user){
                echo $user->name .' was found-'.$user->id;
                $user->update(['last_promoted'=>$old_user->last_promoted]);
                echo '<br>';
            
            }else{
                echo $old_user->name.' was not found-'.$old_user->id;
                echo '<br>';
            } 
            
            
            
            
        }
        
        return 'success';
        
        
    }
    public function apiUsers(Request $request)
    {
         $pre_users= User::where('status','!=',2)->get();
        $users=$pre_users->map(function($item,$key){
            $gc = explode(" ", $item->name);
            return [
         
            'personnelFileNo'=>$item->emp_num,
            'personnelFirstName'=>$gc[0],
            'personnelLastName'=>end($gc),
            'personnelEmail'=>$item->email,
             'personnelPhone'=>$item->phone,
              'personnelAddress'=>$item->address,
               'personnelDesignation'=>$item->rank?$item->rank->name:'',
                'personnelDepartment'=>$item->department?$item->department->name:'',
                 'personnelDivision'=>$item->division?$item->division->name:'',
                  'personnelLevel'=>$item->rank?($item->rank->grade?$item->rank->grade->level:""):"",
                  'personnelDateOfAppointment'=>date('Y-m-d',strtotime($item->hiredate)),
                   'personnelRegional'=>$item->emp_num,
                    'personnelZonal'=>$item->field_office?($item->field_office->zone?$item->field_office->zone->name:""):"",
                     'personnelState'=>$item->state?$item->state->name:'',
                      'personnelLGA'=>ucfirst($item->lga?$item->lga->name:''),
                       'personnelBankName'=>$item->bank?$item->bank->name:'',
                        'personnelAccountName'=>$item->name,
                         'personnelAccountNo'=>$item->bank_account_no,
                          'personnelBankSortCode'=>"",
                           'personnelTIN'=>""];
        });
        return $users->all();
    }
    public function apiUser(Request $request,$file_id){
        $pre_user=User::where('status','!=',2)->where('emp_num',$file_id)->get();
        $user=$pre_user->map(function($item,$key){
             $gc = explode(" ", $item->name);
            return [
           
            'personnelFileNo'=>$item->emp_num,
            'personnelFirstName'=>$gc[0],
            'personnelLastName'=>end($gc),
            'personnelEmail'=>$item->email,
             'personnelPhone'=>$item->phone,
              'personnelAddress'=>$item->address,
               'personnelDesignation'=>$item->rank?$item->rank->name:'',
                'personnelDepartment'=>$item->department?$item->department->name:'',
                 'personnelDivision'=>$item->division?$item->division->name:'',
                  'personnelLevel'=>$item->rank?($item->rank->grade?$item->rank->grade->level:""):"",
                  'personnelDateOfAppointment'=>date('Y-m-d',strtotime($item->hiredate)),
                   'personnelRegional'=>$item->emp_num,
                    'personnelZonal'=>$item->field_office?($item->field_office->zone?$item->field_office->zone->name:""):"",
                     'personnelState'=>$item->state?$item->state->name:'',
                      'personnelLGA'=>ucfirst($item->lga?$item->lga->name:''),
                       'personnelBankName'=>$item->bank?$item->bank->name:'',
                        'personnelAccountName'=>$item->name,
                         'personnelAccountNo'=>$item->bank_account_no,
                          'personnelBankSortCode'=>"",
                           'personnelTIN'=>""];
        });
         return $user->all();
    }
}
