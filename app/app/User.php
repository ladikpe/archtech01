<?php

namespace App;

use App\Traits\General;
use App\Traits\ModelTraits\UserHelperTrait;
use App\Traits\TrainingTraits\UserFilterTrait;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
// use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use LogsActivity;
    use General;
    use CausesActivity;
    use UserHelperTrait;
    use UserFilterTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;
    protected $fillable = ['id','name', 'email', 'password','emp_num','sex','dob','phone','marital_status','company_id','branch_id','job_id','hiredate','role_id','image','remember_token','created_at','updated_at','address','lga_id','employment_status','superadmin','bank_id','bank_account_no','state_id','country_id','grade_id','line_manager_id','payroll_type','project_salary_category_id','last_login_at','last_login_ip','union_id','section_id','expat','confirmation_date','image_id','last_change_approved','last_change_approved_by','last_promoted','active','pension_fund_administrator_id','pension_account_no','field_office_id','cadre_id','rank_id','unit_id','workstate_id','date_of_present_appointment','department_id','division_id'];
    protected static $logAttributes = ['name', 'email', 'password','emp_num','sex','dob','phone','marital_status','company.name','branch.name','job.title','hiredate','role.name','image','remember_token','created_at','updated_at','address','lga.name','employment_status','superadmin','bank.bank_name','bank_account_no','state.name','country.name','grade.level','plmanager.name','payroll_type','project_salary_category.name','union.name','section.name','expat','confirmation_date','image_id','last_promoted','active','pension_fund_administrator.name','pension_account_no','field_office_id','cadre_id','rank_id','unit_id','workstate_id','date_of_present_appointment','department_id','division_id'];
    protected static $ignoreChangedAttributes = ['created_at','updated_at','last_change_approved','last_change_approved_by','last_login_at','last_login_ip'];

    protected $dates=['hiredate',    'last_promoted', 'dob'];

    protected $appends=['years_of_service','months_of_service','user_image','hire_age', 'age','eligible'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $guarded = ['password'];
    protected $hidden = [
        'password', 'remember_token',
    ];

     /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public function user_temp()
    {
        return $this->hasOne('App\UserTemp','user_id');
    }
    protected static function boot()
    {
        parent::boot();
        if(!\Auth::guest()){
        $auth = \Auth::user();
    //     if (session()->has('company_id')) {
    //     $comp_id=session('company_id');
    //     static::addGlobalScope('company_id', function (Builder $builder) use ($auth,$comp_id){

    //            if ($auth->role->permissions->contains('constant', 'group_access')) {
    //                     if ($comp_id==0) {
    //                          $builder->where('company_id', '>',  0);
    //                     } else {
    //                         $builder->where('company_id',  $comp_id);
    //                     }



    //             }
    //             else{
    //                 $builder->where('company_id', $auth->company_id);
    //             }

    //     });
    // }else{
    //     if (\Auth::user()->company and \Auth::user()->role->permissions->contains('constant', 'group_access')) {

    //     static::addGlobalScope('company_id', function (Builder $builder) use ($auth){


    //                     $builder->where('company_id', '>',  0);

    //     });
    //     session(['company_id'=>0]);


    // }elseif (\Auth::user()->company) {
    //     static::addGlobalScope('company_id', function (Builder $builder) use ($auth){


    //                 $builder->where('company_id', $auth->company_id);


    //     });

    //     $company=\App\Company::where('id',\Auth::user()->company_id)->get()->first();
    //     session(['company_id'=>$company->id]);


    // }else{
    //     $company=\App\Company::where('is_parent',1)->get()->first();
    //     static::addGlobalScope('company_id', function (Builder $builder) use ($company){


    //                 $builder->where('company_id', $company->id);


    //     });


    //     session(['company_id'=>$company->id]);

    // }
    // }


        static::addGlobalScope('company_id', function (Builder $builder) use ($auth){

               if ($auth->role->permissions->contains('constant', 'group_access')) {
                        $builder->where('company_id', '>',  0);

                }
                else{
                    $builder->where('company_id', $auth->company_id);
                }

        });
        }
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch')->withDefault();
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
    public function division()
    {
        return $this->belongsTo('App\Division','division_id');
    }
    public function job()
    {
        return $this->belongsTo('App\Job');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }

    public function getUserChangesAttribute(){

        $new_data=collect(\App\UserTemp::where('user_id',$this->id)->first())->map(function($value){
            return $value;
        });
        return $new_data;
        $old_data=\App\User::where('id',$this->id)->first();
        $diff=collect($old_data)->diffAssoc(collect($new_data))->reject(function($key,$value){
            return in_array($value, ['created_at','updated_at','last_change_approved','last_change_approved_by','last_login_at','last_login_ip','last_change_approved_on']);
        })->all();
        $real_old_data=collect($new_data)->diffAssoc(collect($old_data))->reject(function($key,$value){
            return in_array($value, ['created_at','updated_at','last_change_approved','last_change_approved_by','last_login_at','last_login_ip','last_change_approved_on']);
        })->all();
       return $final_diff=collect(['attributes'=>$diff,'old'=>$real_old_data]);




    }
    // public function subsidiary()
    // {
    //     return $this->belongsTo('App\Subsidiary');
    // }
    //Nok is the next of kin
    public function nok()
    {
        return $this->hasOne('App\Nok');
    }
    public function nok_temp()
    {
        return $this->hasOne('App\NokTemp');
    }
    public function jobs()
    {
        return $this->belongsToMany('App\Job','employee_job','user_id','job_id')->withPivot('started', 'ended')->withTimestamps();
    }
    public function dependants()
    {
        return $this->hasMany('App\Dependant','user_id');
    }
    public function employmentHistories()
    {
        return $this->hasMany('App\EmploymentHistory');
    }
    public function promotionHistories()
    {
        return $this->hasMany('App\PromotionHistory');
    }
    public function educationHistories()
    {
        return $this->hasMany('App\EducationHistory','emp_id');
    }
    public function skills()
    {
        return $this->belongsToMany('App\Skill')->using('App\UserSkillCompetency')->withTimestamps()->withPivot('competency_id');
    }

    public function profHistories()
    {
        return $this->hasMany('App\ProfHistory');
    }
    public function socialMediaAccounts()
    {
        return $this->belongsToMany('App\SocialMediaAccount','user_social_media_account','user_id','social_media_account_id');
    }
    public function managers()
    {
        return $this->belongsToMany('App\User','employee_manager','employee_id','manager_id')->withoutGlobalScopes()->withTimestamps();
    }
    public function employees()
    {
        return $this->belongsToMany('App\User','employee_manager','manager_id','employee_id')->withTimestamps();
    }
    public function employmentStatus()
    {
        return $this->belongsTo('App\EmploymentStatus')->withDefault();
    }
    public function getmyStatusAttribute(){

        switch ($this->status){
            case 0:
                return $this->getHumanReadableProbationStatus();
            case 1:
                return 'Confirmed';
            case 2:
                return 'Disengaged';
            default:
                return 'N/A';
        }





    }



    // public function grades()
    // {
    //     return $this->hasManyThrough('App\Grade','App\PromotionHistory');
    // }
    public function grade()
    {
        return $this->belongsTo('App\Grade','grade_id');
    }
    public function performanceseason(){
         $checkseason= \App\PerformanceSeason::select('reviewStart')->value('reviewStart');
             return $checkseason;

    }
    public function quarterName($num){
        switch ($num) {
            case 1:
               return 'First';
                break;
                case 2:
               return 'Second';
                break;
                case 3:
               return 'Third';
                break;
                case 4:
               return 'Fourth';
                break;

            default:
                # code...
                break;
        }

        // $formatter = new \NumberFormatter('en_US', \NumberFormatter::SPELLOUT);
        // $formatter->setTextAttribute(\NumberFormatter::DEFAULT_RULESET,"%spellout-ordinal");
        // return ucfirst($formatter->format($num));
    }
  public function progressreport(){
        return $this->hasMany('App\ProgressReport','emp_id');
    }

public function getquarter(){

    //getquarter
    $review=\App\PerformanceSeason::value('reviewFreq');
    $review=$review==0 ? 1: $review;
        return 12/$review;

  }
    public function getEmploymentStatusAttribute(){

        return $this->employment_status_id==1 ? 'Locked' : 'Open';
    }

    public function goal(){
        return $this->hasMany('App\Goal','user_id')->withDefault();
    }

     public function getProbationStatusAttribute(){
          if(!is_null($this->hiredate) && $this->hiredate->diffInDays()<=180){
            return '<span class="tag tag-warning">On-Probation</span>';
          }
          elseif(!is_null($this->hiredate) && $this->hiredate->diffInDays()>180 && $this->confirmed==1){
            return '<span class="tag tag-success">Confirmed</span>';
          }
          else{
            return 'N/A';
          }
        }
    public function getEmployeeeJobAttribute(){
        $getLattest=\App\EmployeeJob::where('user_id',$this->id)->orderBy('started','desc')->value('job_id');
        return $getLattest;
    }
    // public function getDepartmentAttribute(){
    //     $getdept=\App\Job::where('id',$this->getEmployeeeJobAttribute())->value('department_id');
    //     return $getdept;
    // }

    public function position()
    {
        return $this->belongsTo('App\Position','position_id');
    }
    public function location()
    {
        return $this->belongsTo('App\Location','location_id');
    }
    public function category()
    {
        return $this->belongsTo('App\StaffCategory','staff_category_id');
    }
    public function employee_type()
    {
        return $this->belongsTo('App\EmployeeType','employee_type_id');
    }
    public function costcenter()
    {
        return $this->belongsTo('App\CostCenter','costcenter_id');
    }
    public function attendances()
    {
         return $this->hasMany('App\Attendance','emp_num','emp_num');
    }
    public function attendancedetails()
    {
         return $this->hasManyThrough('App\AttendanceDetail','App\Attendance','emp_num','emp_num');
    }
    public function timesheets()
    {
        return $this->hasManyThrough('App\Timesheet','App\TimesheetDetail','user_id');
    }
    public function timesheetdetails()
    {
        return $this->hasMany('App\TimesheetDetail','user_id');
    }
    public function shifts()
    {
         return $this->belongsToMany('App\Shift','user_shift_schedule','user_id','shift_id');
    }
    public function shift_schedules()
    {
         return $this->belongsToMany('App\ShiftSchedule','user_shift_schedule','user_id','shift_schedule_id');
    }
    public function usershiftschedules()
    {
        return $this->hasMany('App\UserShiftSchedule');
    }
    public function initiatedShiftSwaps()
    {
        return $this->hasMany('App\UserShiftSchedule','owner_id');
    }
    public function suggestedShiftSwaps()
    {
        return $this->hasMany('App\UserShiftSchedule','swapper_id');
    }
    public function SalaryComponents()
    {
        return $this->belongsToMany('App\SalaryComponent','salary_component_exemptions','user_id','salary_component_id');
    }
    public function specificSalaryComponents(){
         return $this->hasMany('App\SpecificSalaryComponent','emp_id');
    }
    public function leave_requests()
    {
        return $this->hasMany('App\LeaveRequest','user_id');
    }
    public function user_groups()
    {
        return $this->belongsToMany('App\UserGroup','user_group_user','user_id','user_group_id');
    }
    public function loan_requests()
    {
        return $this->hasMany('App\LoanRequest','user_id');
    }
    public function payroll_details()
    {
         return $this->hasMany('App\PayrollDetail','user_id');
    }
    public function payrolls()
    {
        return $this->hasMany('App\Payroll','user_id');
    }

    public function stages()
    {
        return $this->morphMany('App\Stage', 'stageable');
    }
    public function lga()
    {
       return $this->belongsTo('App\LocalGovernment');
    }
     public function state()
    {
       return $this->belongsTo('App\State');
    }
     public function country()
    {
       return $this->belongsTo('App\Country');
    }
    public function getDRLeaveApprovals()
    {
        $lm_id=$this->id;

        return \App\LeaveApproval::whereHas('leave_request',function($query) use ($lm_id){
                     $query->whereHas('user',function($query) use ($lm_id){
                                $query->whereHas('managers',function($query) use ($lm_id){
                                        $query->where('manager_id',$lm_id)->withoutGlobalScopes();
                                })->withoutGlobalScopes();
                        })->withoutGlobalScopes();
                })->withoutGlobalScopes()
                ->whereHas('stage.role',function($query) use($lm_id){
                $query->where('manages','dr');

                 })->where('status',0)
                ->get();
        # code...
    }
    public function getDRDocumentRequestApprovals()
    {
        $lm_id=$this->id;

        return \App\DocumentRequestApproval::whereHas('document_request',function($query) use ($lm_id){
            $query->whereHas('user',function($query) use ($lm_id){
                $query->whereHas('managers',function($query) use ($lm_id){
                    $query->where('manager_id',$lm_id)->withoutGlobalScopes();
                })->withoutGlobalScopes();
            })->withoutGlobalScopes();
        })->withoutGlobalScopes()
            ->whereHas('stage.role',function($query) use($lm_id){
                $query->where('manages','dr');

            })->where('status',0)
            ->get();
        # code...
    }
    public function getDRPayrollApprovals()
    {
        $lm_id=$this->id;

        return \App\PayrollApproval::whereHas('payroll',function($query) use ($lm_id){
            $query->whereHas('user',function($query) use ($lm_id){
                $query->whereHas('managers',function($query) use ($lm_id){
                    $query->where('manager_id',$lm_id)->withoutGlobalScopes();
                })->withoutGlobalScopes();
            })->withoutGlobalScopes();
        })->withoutGlobalScopes()
            ->whereHas('stage.role',function($query) use($lm_id){
                $query->where('manages','dr');

            })->where('status',0)
            ->get();
        # code...
    }

    public function getDREmployeeReimbursementApprovals()
    {
        $lm_id=$this->id;
        return \App\EmployeeReimbursementApproval::whereHas('employee_reimbursement',function($query) use ($lm_id){
            $query->whereHas('user',function($query) use ($lm_id){
                $query->whereHas('managers',function($query) use ($lm_id){
                    $query->where('manager_id',$lm_id)->withoutGlobalScopes();
                })->withoutGlobalScopes();
            })->withoutGlobalScopes();
        })->withoutGlobalScopes()
            ->whereHas('stage.role',function($query) use($lm_id){
                $query->where('manages','dr');

            })->where('status',0)
            ->get();
        # code...
    }
    public function getDRSeparationApprovals()
    {
        $lm_id=$this->id;
        return \App\SeparationApproval::whereHas('separation',function($query) use ($lm_id){
            $query->whereHas('user',function($query) use ($lm_id){
                $query->whereHas('managers',function($query) use ($lm_id){
                    $query->where('manager_id',$lm_id)->withoutGlobalScopes();
                })->withoutGlobalScopes();
            })->withoutGlobalScopes();
        })->withoutGlobalScopes()
            ->whereHas('stage.role',function($query) use($lm_id){
                $query->where('manages','dr');

            })->where('status',0)
            ->get();
        # code...
    }
     public function getDRPostingApprovals()
    {
        $lm_id=$this->id;
        return \App\PostingApproval::whereHas('posting',function($query) use ($lm_id){
            $query->whereHas('user',function($query) use ($lm_id){
                $query->whereHas('managers',function($query) use ($lm_id){
                    $query->where('manager_id',$lm_id)->withoutGlobalScopes();
                })->withoutGlobalScopes();
            })->withoutGlobalScopes();
        })->withoutGlobalScopes()
            ->whereHas('stage.role',function($query) use($lm_id){
                $query->where('manages','dr');

            })->where('status',0)
            ->get();
        # code...
    }

    public function separation_approvals(){
        return $this->hasMany('App\SeparationApproval','approver_id');
    }
    public function posting_approvals(){
        return $this->hasMany('App\PostingApproval','approver_id');
    }
     public function leave_approvals(){
        return $this->hasMany('App\LeaveApproval','approver_id');
    }
    public function payroll_approvals(){
        return $this->hasMany('App\PayrollApproval','approver_id');
    }
    public function document_requests(){
        return $this->hasMany('App\DocumentRequest','user_id');
    }
    public function document_request_approvals(){
        return $this->hasMany('App\DocumentRequestApproval','approver_id');
    }
    public function employee_reimbursements(){
        return $this->hasMany('App\EmployeeReimbursement','user_id');
    }
    public function employee_reimbursement_approvals(){
        return $this->hasMany('App\EmployeeReimbursementApproval','approver_id');
    }
    public function user_daily_shifts()
    {
         return $this->hasMany('App\UserDailyShift','user_id');
    }
    public function user_cust_attendances()
    {
         return $this->hasMany('App\CustAttendance','user_id');
    }

    public function my_departments()
    {
         return $this->hasMany('App\Department','manager_id');
    }

    //RELATIONSHIP FOR TRAINING MODULE STARTS
    public function TrainingRecommended()
    {
        return $this->hasMany('App\TrainingRecommended', 'trainee_id', 'suggester_id', 'approver_id');
    }

    public function TrainingBudget()
    {
        return $this->hasMany('App\TrainingBudget', 'status_id');
    }

    public function trainings()
    {
        return $this->belongsToMany('training_user', 'App\User', 'user_id', 'training_id');
    }

    // public function trainings()
    // {
    //     return $this->belongsToMany('training_user', 'App\User', 'user_id', 'training_id');
    // }




    public function TrainingUser()
    {
        return $this->hasMany('App\TrainingUser', 'user_id');
    }
     public function rec_tranings()
    {
        return $this->belongsToMany('App\TrainingRecommended','rec_training_trainee' ,'trainee_id','rec_training_id');
    }

    public function separations()
    {
        return $this->hasMany('App\Separation');
    }
    public function applications()
    {
        return $this->morphMany('App\JobApplication', 'applicable');
    }
    public function favorites()
    {
        return $this->morphMany('App\JobFavorite', 'favorable');
    }

    public function plmanager()
    {
        return $this->belongsTo('App\User','line_manager_id')->withoutGlobalScopes();
    }
    public function pdreports()
    {
        return $this->hasMany('App\User','line_manager_id')->withoutGlobalScopes();
    }

    public function getOnlygradeAttribute()
    {
         $gc = explode("-", $this->grade->level);
         return $gc[0];
    }
    public function getOnlylevelAttribute()
    {
        if (strpos( $this->grade->level,'-') !== false) {
                 $gc = explode("-", $this->grade->level);
         return $gc[1];
            }else{
                return '';
            }

    }
    public function project_salary_category()
    {
        return $this->belongsTo('App\PaceSalaryCategory','project_salary_category_id');
    }

    public function project_salary_timesheets()
    {
        return $this->hasMany('App\ProjectSalaryTimesheet','project_salary_category_id');
    }
    public function suspensions()
    {
        return $this->hasMany('App\Suspension');
    }
    public function suspension_deductions()
    {
        return $this->hasManyThrough('App\SuspensionDeduction', 'App\Suspension');
    }
    public function union()
    {
        return $this->belongsTo('App\UserUnion','union_id');
    }
    public function section()
    {
        return $this->belongsTo('App\UserSection','section_id');
    }
    public function leave_spills()
    {
        return $this->hasMany('App\LeaveSpill', 'user_id');
    }
    public function getYearsOfServiceAttribute()
    {
        $today=\Carbon\Carbon::today();
        if($this->hiredate!=null){
             return $this->hiredate->diffInYears($today);
        }else{
            return 0;
        }

    }
    public function getMonthsOfServiceAttribute()
    {
        $today=\Carbon\Carbon::today();
        if($this->hiredate!=null){
        return $this->hiredate->diffInMonths($today);
        }else{
            return 0;
        }
    }
    public function leave_plans()
    {
        return $this->hasMany('App\LeavePlan','user_id');
    }


    public function getuserImageAttribute(){
        $image= file_exists(public_path('uploads/avatar'.$this->image))?asset('uploads/avatar'.$this->image):($this->sex=='M'?asset('global/portraits/male-user.png'):asset('global/portraits/female-user.png'));
    return ($image);
    }

    public function e360_reviews(){
        return $this->hasMany('App\E360Evaluation','user_id');
    }
    public function my_e360_reviews(){
        return $this->hasMany('App\E360Evaluation','evaluator_id');
    }
    public function aper_assessments(){
        return $this->hasMany('App\AperAssessment','employee_id');
    }
    
    
    protected $date=['hiredate'];



   function offline_trainings(){
    	return $this->hasMany('App\Tr_UserOfflineTraining','user_id');
    }

    public function attendance_reports(){
        return $this->hasMany('App\AttendanceReport');
    }
    public function postings(){
        return $this->hasMany('App\Posting');
    }
    public function polls(){
       return $this->hasMany('App\Poll');
    }

    public function poll_responses(){
       return $this->hasMany('App\Poll');
    }

    public function rank()
    {
        return $this->belongsTo('App\Rank','rank_id')->withDefault();
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit','unit_id')->withDefault();
    }
    public function cadre()
    {
        return $this->belongsTo('App\Cadre','cadre_id')->withDefault();
    }
    public function field_office()
    {
        return $this->belongsTo('App\FieldOffice','field_office_id')->withDefault();
    }
    public function workstate()
    {
        return $this->belongsTo('App\State','workstate_id')->withDefault();
    }
    public function pension_fund_administrator()
    {
        return $this->belongsTo('App\PensionFundAdministrator','pension_fund_administrator_id')->withDefault();
    }
    public function aspiring_rank(){
        return $this->getNextRank($this->rank_id);
    }


    public function getNextRank($old_rank){
        $current_rank=Rank::where('id',$old_rank)->first();
        $user_cadre_id=$current_rank->cadre_id;
        $current_position=$current_rank->position;
        if(!$current_position){
            //if current rank has no position
            return ['id'=>$old_rank,'name'=>$current_rank->name];
        }
        $next_position=$current_position+1;
        $next_position_rank=Rank::where('position',$next_position)->where('cadre_id',$user_cadre_id)->first();
        if(!$next_position_rank){
            //if no higher rank
            return ['id'=>$old_rank,'name'=>$current_rank->name];
        }
        $new_rank_id=$next_position_rank->id;
        return ['id'=>$new_rank_id,'name'=>$next_position_rank->name];


    }

    public function getPresentAppointmentAge(){
        $last_promoted_year=\Carbon\Carbon::today()->format('Y');
        $this_year=\Carbon\Carbon::today()->format('Y');
        if($this->date_of_present_appointment!=null){
            $last_promoted_year= Carbon::parse($this->date_of_present_appointment)->format('Y');
        }
        return $this_year-$last_promoted_year;
    }

    public function calculateYearEligibility(){

       $grade=$this->rank->grade ? $this->rank->grade->level: 0;
       if ($grade>=0 && $grade<=6){
           return 2;
       }
       elseif ($grade>=7 && $grade<=14){
           return 3;
       }
       elseif ($grade>=15 && $grade<=17){
           return 4;
       }
    }

    public function getEligibleAttribute(){
       $appointment_age=$this->getPresentAppointmentAge();
       $years_eligibility=$this->calculateYearEligibility();
       return $appointment_age>=$years_eligibility;
    }

    public function scopeEligibleStaff($query){//this is for people that will write the exam
        $advancement_cadres=Cadre::where('promotion_type','advancement')->pluck('id')->toArray();
        $grades_not_8=Grade::where('level','8')->pluck('id')->toArray();
        $ranks_for_grade_8=Rank::whereIn('grade_id',$grades_not_8)->whereIn('cadre_id',$advancement_cadres)->pluck('id')->toArray();
       return $query->get()->where('eligible',true)->whereNotIn('rank_id',$ranks_for_grade_8);
    }


/////FERMA VOTING MODULE
    /*function votes(){
        return $this->hasMany('\App\Voting', 'vote_for');
    }*/
    function votes_casted(){
        return $this->hasMany('\App\Voting', 'voter_id');
    }

    function myvote(){
        return $this->hasMany('\App\Voting', 'voted_for_id');
    }




        public function getYearDiff(){
            $prev  =\Carbon\Carbon::parse($this->last_promoted);
            $end  = \Carbon\Carbon::now();
            return $prev->diffInYears($end);
        }


        public function getHireAgeAttribute(){
            $prev  =\Carbon\Carbon::parse($this->hiredate);
            $end  = \Carbon\Carbon::now();
            return $prev->diffInYears($end);
        }
        public function getHireAgeYearAttribute(){
            $prev  =\Carbon\Carbon::parse($this->hiredate);
            $end  = \Carbon\Carbon::now();
            return $prev->diffInYears($end);
        }

        public function getAgeAttribute(){
            $prev  =\Carbon\Carbon::parse($this->dob);
            $end  = \Carbon\Carbon::now();
            return $prev->diffInYears($end);
        }

        //protected $appends= ['hire_age', 'age'];
        //protected $dates = ['hiredate','last_promoted', 'dob'];


public function resolveType($type){
			switch ($type) {
			    case 0:
				$status='probation';
				break;
				case 1:
				$status='active';
				break;
				case 2:
				$status='dismissed';
				break;
				case 3:
				$status='suspended';
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
		public function updateStatus($status){
			$this->where('id',$this->id)->update(['status'=>$status]);
		}

}
