<?php



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::get('/artisan',function(){

   \Artisan::call('migrate');

});

// Route::get('/update_aper',function(){
//     $obtainable=165;
//     // $eval=\App\AperAssessment::find(3848);
//     // $eval->total_score=$eval->score/20*165;
//     // $eval->save();
//     $evaluations=\App\AperAssessment::where('id','<=',3847)->get();
//     foreach($evaluations as $evaluation){
//         $evaluation->score=$evaluation->total_score/165*20;
//         $evaluation->save();
//     }
    

  
// });




Route::group(['middleware' => 'prevent-back-history'],function(){

Route::get('/tester', function () {

    return view('test2');

});

Route::get('/emp', function () {

    return view('empmgt.partials.info');

});

Route::get('/', function () {

    return redirect(route('home'));

});



Auth::routes();

//user routes

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('import','ImportController')->middleware(['permission:manage_import','auth']);

Route::resource('separation','SeparationController')->middleware(['auth']);

Route::get('users/modal/{user_id}','UserController@modal')->name('users.modal')->middleware(['auth']);

Route::get('users/assignrole','UserController@assignRole')->name('users.assignrole')->middleware(['auth']);

Route::get('users/alterstatus','UserController@alterStatus')->name('users.alterstatus')->middleware(['auth']);
Route::get('users/resetpassword','UserController@resetPassword')->name('users.resetpassword')->middleware(['permission:reset_password','auth']);
Route::get('users/sync-state','UserController@syncLastPromoted')->name('users.syncState')->middleware(['auth']);

    Route::get('users/alterloginstatus','UserController@alterLoginStatus')->name('users.alterloginstatus')->middleware(['auth']);

Route::get('users/alteremployeestatus','UserController@alterEmployeeStatus')->name('users.alteremployeestatus')->middleware(['auth']);



Route::get('users/assignmanager','UserController@assignManager')->name('users.assignmanager')->middleware(['auth']);
Route::get('retirement_list','UserController@retirementList')->name('users.retirement_list')->middleware(['auth']);

Route::get('users/assigngroup','UserController@assignGroup')->name('users.assigngroup')->middleware(['auth']);

Route::get('users/search','UserController@search')->name('users.search')->middleware(['auth']);

Route::get('organogram','UserController@viewOrganogram')->name('users.organogram')->middleware(['auth']);

Route::get('dept-organogram/{id}','UserController@deptOrganogram')->name('users.dept_organogram')->middleware(['auth']);

Route::get('team-organogram','UserController@teamOrganogram')->name('users.team_organogram')->middleware(['auth']);

Route::get('dept-organogram','UserController@oDepartments')->name('users.departments')->middleware(['auth']);

Route::get('myteam-organogram','UserController@myteamOrganogram')->name('users.myteam_organogram')->middleware(['auth']);

Route::get('user/dr','UserController@directReports')->name('users.dr')->middleware(['auth']);

Route::get('directory','UserController@viewDirectory')->name('users.directory')->middleware(['auth']);

Route::post('users/new','UserController@saveNew')->name('users.savenew');

Route::resource('userprofile','UserProfileController')->middleware(['auth']);

Route::resource('users', 'UserController')->middleware(['auth']);

Route::get('users/company/departmentsandbranches/{company_id}','UserController@getCompanyDepartmentsBranches')->name('users.companydepartmentsandbranches')->middleware(['permission:edit_user_advanced','auth']);

Route::get('users/department/jobroles/{department_id}','UserController@getDepartmentJobroles')->middleware(['permission:edit_user_advanced','auth']);



    Route::get('groups/assignrole','UserGroupController@assignRole')->name('groups.assignrole')->middleware(['auth','permission:manage_user']);

Route::resource('groups', 'UserGroupController',['names'=>['create'=>'groups.create','index'=>'groups','store'=>'groups.save','edit'=>'groups.edit','update'=>'groups.update','show'=>'groups.view','destroy'=>'groups.delete']])->middleware(['permission:edit_user_advanced','auth']);

Route::get('setfy/{year}','HomeController@setfy');

Route::get('setcpny/{company_id}','HomeController@setcpny');

//end user routes

//settings routes

Route::get('/settings', 'GlobalSettingController@index')->name('settings')->middleware(['permission:edit_settings','auth'])->middleware(['permission:edit_settings','auth']);

Route::get('/settings/companies', 'CompanySettingController@companies')->name('companies')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/companies', 'CompanySettingController@saveCompany')->name('companies.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/companies/{company_id}', 'CompanySettingController@getCompany')->name('companies.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/companies/parent/{company_id}', 'CompanySettingController@changeParentCompany')->name('companies.parent')->middleware(['permission:edit_settings','auth']);



Route::get('/settings/departments/{company_id}', 'CompanySettingController@departments')->name('departments')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/departments', 'CompanySettingController@saveDepartment')->name('departments.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/department/{department_id}', 'CompanySettingController@getDepartment')->name('departments.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/departments/delete/{department_id}', 'CompanySettingController@deleteDepartment')->name('departments.delete')->middleware(['permission:edit_settings','auth']);



/////////////////////////////////////////

Route::get('/settings/divisions/{department_id}', 'CompanySettingController@divisions')->name('divisions')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/divisions', 'CompanySettingController@saveDivision')->name('divisions.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/division/{division_id}', 'CompanySettingController@getDivision')->name('divisions.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/divisions/delete/{division_id}', 'CompanySettingController@deleteDivision')->name('divisions.delete')->middleware(['permission:edit_settings','auth']);





///////////////////////////////////////



Route::get('/settings/branches/{company_id}', 'CompanySettingController@branches')->name('branches')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/branches', 'CompanySettingController@saveBranch')->name('branches.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/branch/{branch_id}', 'CompanySettingController@getBranch')->name('branches.show');



Route::get('/settings/jobs/{company_id}', 'CompanySettingController@jobs')->name('jobs')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/jobs', 'CompanySettingController@saveJob')->name('jobs.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/jobs/{job_id}', 'CompanySettingController@getJob')->name('jobs.show')->middleware(['permission:edit_settings','auth']);



// system settings start

Route::get('/settings/system', 'SystemSettingController@index')->name('systemsettings')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/system/switchhassub', 'SystemSettingController@switchHasSubsidiary')->name('systemsettings.switchhassub')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/system/switchuseparent', 'SystemSettingController@switchUseParentSetting')->name('systemsettings.switchuseparent')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/system/whitelabel', 'SystemSettingController@whiteLabel')->name('systemsettings.store')->middleware(['permission:edit_settings','auth']);



// system settings end





//employee settings

Route::get('/settings/employee', 'EmployeeSettingController@index')->name('employeesettings')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/grades', 'EmployeeSettingController@saveGrade')->name('grades.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/grades/{grade_id}', 'EmployeeSettingController@getGrade')->name('grades.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/grades/delete/{grade_id}', 'EmployeeSettingController@deleteGrade')->name('grades.delete')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/grade_categories', 'EmployeeSettingController@saveGradeCategory')->name('grade_categories.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/grade_categories/{grade_category_id}', 'EmployeeSettingController@getGradeCategory')->name('grade_categories.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/grade_categories/delete/{grade_category_id}', 'EmployeeSettingController@deleteGradeCategory')->name('grade_categories.delete')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/qualifications', 'EmployeeSettingController@saveQualification')->name('qualifications.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/qualifications/{qualification_id}', 'EmployeeSettingController@getQualification')->name('qualifications.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/qualifications/delete/{qualification_id}', 'EmployeeSettingController@deleteQualification')->name('qualifications.delete')->middleware(['permission:edit_settings','auth']);



//employee settings end

//leave settings

Route::get('/settings/leave', 'LeaveSettingController@index')->name('leavesettings')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/leaves/save_policy', 'LeaveSettingController@savePolicy')->middleware(['permission:edit_settings','auth'])->name('leave_policy.store');



Route::post('/settings/holidays', 'LeaveSettingController@saveHoliday')->name('holidays.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/holiday/{holiday_id}', 'LeaveSettingController@getHoliday')->name('holidays.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/holidays/delete/{holiday_id}', 'LeaveSettingController@deleteHoliday')->name('holidays.delete')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/leaves', 'LeaveSettingController@saveLeave')->name('leaves.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/leave/{leave_id}', 'LeaveSettingController@getLeave')->name('leaves.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/leaves/delete/{leave_id}', 'LeaveSettingController@deleteLeave')->name('leaves.delete')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/leaveperiods', 'LeaveSettingController@saveLeavePeriod')->name('leaveperiods.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/leaveperiods/{leaveperiod_id}', 'LeaveSettingController@getLeavePeriod')->name('leaveperiods.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/leaveperiods/delete/{leaveperiod_id}', 'LeaveSettingController@deleteLeavePeriod')->name('leaveperiods.delete')->middleware(['permission:edit_settings','auth']);

//leave settings end

// attendance settings

Route::get('/settings/attendance', 'AttendanceSettingController@index')->name('attendancesettings')->middleware(['permission:edit_settings','auth']);

Route::post('/settings/working_period', 'AttendanceSettingController@saveWorkingPeriod')->name('working_periods.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/working_period/{working_period_id}', 'AttendanceSettingController@getWorkingPeriod')->name('working_periods.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/working_period/delete/{working_period_id}', 'AttendanceSettingController@deleteWorkingPeriod')->name('working_periods.delete')->middleware(['permission:edit_settings','auth']);

Route::post('/save/attendance/Settings', 'AttendanceSettingController@saveAttendanceSettings')->name('save.attendance.settings')->middleware(['permission:edit_settings','auth']);



Route::get('/settings/shift', 'LeaveSettingController@shiftindex')->name('shiftsettings')->middleware(['permission:edit_settings','auth']);





Route::post('/settings/project', 'AttendanceSettingController@saveProject')->name('projects.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/project/{project_id}', 'AttendanceSettingController@getProject')->name('projects.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/project/delete/{project_id}', 'AttendanceSettingController@deleteProject')->name('projects.delete')->middleware(['permission:edit_settings','auth']);







Route::post('/settings/employeetype', 'AttendanceSettingController@saveEmployeeType')->name('employeetypes.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/employeetype/{employeetype_id}', 'AttendanceSettingController@getEmployeeType')->name('employeetypes.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/employeetype/delete/{employeetype_id}', 'AttendanceSettingController@deleteEmployeeType')->name('employeetypes.delete')->middleware(['permission:edit_settings','auth']);



Route::post('/settings/costcenter', 'AttendanceSettingController@saveCostCenter')->name('costcenters.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/costcenter/{costcenter_id}', 'AttendanceSettingController@getCostCenter')->name('costcenters.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/costcenter/delete/{costcenter_id}', 'AttendanceSettingController@deleteCostCenter')->name('costcenters.delete')->middleware(['permission:edit_settings','auth']);







Route::post('/settings/allowance', 'AttendanceSettingController@saveAllowance')->name('allowances.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/allowance/{allowance_id}', 'AttendanceSettingController@getAllowance')->name('allowances.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/allowance/delete/{allowance_id}', 'AttendanceSettingController@deleteAllowance')->name('allowances.delete')->middleware(['permission:edit_settings','auth']);



Route::post('/settings/shift', 'LeaveSettingController@saveShift')->name('shifts.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/shift/{shift_id}', 'LeaveSettingController@getShift')->name('shifts.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/shift/delete/{shift_id}', 'LeaveSettingController@deleteShift')->name('shifts.delete')->middleware(['permission:edit_settings','auth']);



Route::get('/settings/employeedesignation', 'EmployeeDesignationSettingController@index')->name('employeedesignationsettings')->middleware(['permission:edit_settings','auth']);



Route::post('/settings/position', 'EmployeeDesignationSettingController@savePosition')->name('positions.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/position/{position_id}', 'EmployeeDesignationSettingController@getPosition')->name('positions.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/positions/delete/{position_id}', 'EmployeeDesignationSettingController@deletePosition')->name('positions.delete')->middleware(['permission:edit_settings','auth']);



Route::post('/settings/location', 'EmployeeDesignationSettingController@saveLocation')->name('locations.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/location/{location_id}', 'EmployeeDesignationSettingController@getLocation')->name('locations.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/locations/delete/{location_id}', 'EmployeeDesignationSettingController@deleteLocation')->name('locations.delete')->middleware(['permission:edit_settings','auth']);



Route::post('/settings/staffcategory', 'EmployeeDesignationSettingController@saveStaffCategory')->name('staffcategories.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/staffcategory/{staffcategory_id}', 'EmployeeDesignationSettingController@getStaffCategory')->name('staffcategories.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/staffcategories/delete/{staffcategory_id}', 'EmployeeDesignationSettingController@deleteStaffCategory')->name('staffcategories.delete')->middleware(['permission:edit_settings','auth']);



Route::post('/settings/holiday', 'LeaveSettingController@saveHoliday')->name('holidays.store')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/holiday/{holiday_id}', 'LeaveSettingController@getHoliday')->name('holidays.show')->middleware(['permission:edit_settings','auth']);

Route::get('/settings/holiday/delete/{holiday_id}', 'LeaveSettingController@deleteHoliday')->name('holidays.delete')->middleware(['permission:edit_settings','auth']);



//biometric devices

Route::prefix('bio')->group(function () {

    Route::get('/data', 'BiometricController@data');

    Route::get('/data2', 'AttendancePayrollController@data');

    Route::get('/iclock/cdata', 'BiometricController@checkDevice');

    Route::post('/iclock/cdata', 'BiometricController@receiveRecords');



    Route::get('/softclockin', 'BiometricController@softClockIn')->name('soft.clockin');

    Route::get('/softclockout', 'BiometricController@softClockOut')->name('soft.clockout');

});

Route::get('/enroll-users', 'BiometricController@enrollUsers')->name('enroll-users');

Route::get('/remove-users', 'BiometricController@removeUsers')->name('remove-users');





Route::get('/daily/attendance/reports', 'AttendanceController@dailyAttendance')->name('daily.attendance.report')->middleware(['permission:view_timesheet','auth']);

Route::get('/monthly/attendance/reports', 'AttendanceController@monthlyAttendance')->name('monthly.attendance.report')->middleware(['permission:view_attendance_report','auth']);

Route::get('/attendance/getdetails/{attendance_id}', 'AttendanceController@getDetails')->name('attendance.getdetails')->middleware(['permission:view_timesheet','auth']);

Route::get('/lateness-report', 'AttendanceController@latenessReport')->name('lateness.report')->middleware(['permission:view_attendance_report','auth']);

Route::get('/attendance/staff/{staff}', 'AttendanceController@staffAttendance')->name('attendance.staff')->middleware(['permission:view_attendance_report','auth']);

Route::get('/user/monthly/attendance/{user}/{date}', 'AttendanceController@UserMonthlyAttendance')->middleware(['permission:view_attendance_report','auth']);

//app schedule shift

Route::get('/schedule/shift/app', 'AttendanceController@appScheduleShift')->middleware(['permission:view_attendance_report','auth'])->name('app.schedule.shift');

Route::post('/schedule/shift/app/submit', 'AttendanceController@appScheduleShiftSubmit')->middleware(['permission:view_attendance_report','auth'])->name('app.schedule.shift.submit');

//manual attendance

Route::get('/attendance/manual', 'ManualAttendanceController@manualAttendance')->name('manual.attendance')->middleware(['permission:view_attendance_report','auth']);

Route::post('/attendance/manual', 'ManualAttendanceController@storeManualAttendance')->name('manual.attendance.store')->middleware(['permission:view_attendance_report','auth']);

Route::get('/attendance/manual/excel', 'ManualAttendanceController@manualAttendanceExcelTemplate')->name('manual.attendance.excel.template')->middleware(['permission:view_attendance_report','auth']);

Route::post('/attendance/manual/excel', 'ManualAttendanceController@manualAttendanceExcel')->name('manual.attendance.excel')->middleware(['permission:view_attendance_report','auth']);

Route::get('/attendance/manual/approval/{id}', 'ManualAttendanceController@approveMAStage')->name('manual.attendance.approval')->middleware(['permission:view_attendance_report','auth']);

//attendnace based payroll

Route::get('/attendance/payroll', 'AttendancePayrollController@payroll')->middleware(['permission:run_payroll','auth'])->name('attendance.payroll');

Route::post('/attendance/check-payroll', 'AttendancePayrollController@checkPayroll')->middleware(['permission:run_payroll','auth'])->name('check.attendance.payroll');

Route::post('/attendance/runpayroll', 'AttendancePayrollController@runpayroll')->middleware(['permission:run_payroll','auth'])->name('run.attendance.payroll');

Route::get('/attendance/runpayroll', 'AttendancePayrollController@runpayroll')->middleware(['permission:run_payroll','auth'])->name('run.attendance.payroll');

Route::get('/attendance/payroll/monthly/{id}', 'AttendancePayrollController@monthlyPayroll')->middleware(['permission:run_payroll','auth'])->name('monthly.attendance.payroll');

Route::get('/attendance/recalculate/payroll/{id}', 'AttendancePayrollController@recalculate')->middleware(['permission:run_payroll','auth'])->name('recalculate.attendance.payroll');

Route::get('/attendance/close/payroll/{id}', 'AttendancePayrollController@closePayroll')->middleware(['permission:run_payroll','auth'])->name('close.attendance.payroll');

Route::get('/attendance/previous/payroll/{date}', 'AttendancePayrollController@previousPayroll')->middleware(['permission:run_payroll','auth'])->name('previous.attendance.payroll');



Route::get('/attendance/payroll/download/payslip/{apd}', 'AttendancePayrollController@downloadPayslip')->middleware(['permission:run_payroll','auth'])->name('attendance.payroll.download.payslip');

Route::get('/attendance/payroll/resend/payslip/{apd}', 'AttendancePayrollController@sendSinglePayslip')->middleware(['permission:run_payroll','auth'])->name('attendance.payroll.resend.payslip');



Route::get('/timesheets', 'AttendanceController@timesheets')->name('timesheets')->middleware(['permission:view_timesheet','auth']);

Route::get('/timesheets/{timesheet_id}', 'AttendanceController@timesheetDetail')->name('timesheets.show')->middleware(['permission:view_timesheet','auth']);

Route::get('/usertimesheets/{user_id}/', 'AttendanceController@userTimesheetDetail')->name('timesheets.user')->middleware(['permission:view_timesheet','auth']);

Route::get('/generate_timesheet', 'AttendanceController@queueTimesheet')->name('timesheets.queue')->middleware(['permission:view_timesheet','auth']);

Route::get('/timesheet-excel/{timesheet_id}', 'AttendanceController@timesheetExcel')->name('timesheets.excel')->middleware(['permission:view_timesheet','auth']);

// new shift functions



Route::get('/employee_shift_schedules', 'AttendanceController@employeeShiftSchedules')->name('employeeShiftSchedules')->middleware(['auth']);

Route::get('/export_shift_schedule', 'AttendanceController@exportShiftSchedules')->name('exportShiftSchedules')->middleware(['auth']);

Route::get('/cust_shift_schedules', 'AttendanceController@employeesSchedule')->name('employeesSchedule')->middleware(['auth']);



Route::get('/shift_template_download', 'AttendanceController@downloadShiftUploadTemplate')->name('downloadShiftUploadTemplate')->middleware(['auth']);





Route::post('/import_employee_shift', 'AttendanceController@importUserShifts')->name('importUserShifts')->middleware(['auth']);

// end of new shift funtions

Route::get('/shift_schedules', 'AttendanceController@shift_schedules')->name('shift_schedules')->middleware(['auth']);

Route::get('/shift_schedules/{shift_schedule_id}', 'AttendanceController@shift_schedule_details')->name('shift_schedule.show')->middleware(['auth']);

Route::get('/user_shift_schedules', 'AttendanceController@myShiftSchedule')->name('shift_schedule.user.my')->middleware(['auth']);

Route::get('/user_shift_schedules/{user_id}', 'AttendanceController@userShiftSchedule')->name('shift_schedule.user')->middleware(['auth']);

Route::get('/user_shift_schedule_calendar/{user_id}', 'AttendanceController@userShiftScheduleCalendar')->name('shift_schedule.user_calendar')->middleware(['auth']);

Route::get('/user_shift_schedule_details/{id}', 'AttendanceController@userShiftScheduleDetails')->middleware(['auth']);

Route::get('/my-attendance-calendar', 'AttendanceController@myAttendanceCal')->name('attendance.user.cal')->middleware(['auth']);

Route::get('/user_attendance/{user_id}', 'AttendanceController@myAttendance')->name('attendance.user')->middleware(['auth']);

Route::get('/user_attendance_calendar/{user_id}', 'AttendanceController@myAttendanceCalendar')->name('attendance.user_calendar')->middleware(['auth']);

Route::get('/user_attendance_calendar', 'AttendanceController@shiftUploadedCalendar')->name('attendance.all.user_calendar')->middleware(['auth']);

Route::post('/schedule_shifts','AttendanceController@schedule_shift')->name('schedule_shifts')->middleware(['auth']);

Route::post('/swap_shift','AttendanceController@swapShift')->name('swap_shift')->middleware(['auth']);

Route::get('/shift_swap_cancel/{shift_swap_id}','AttendanceController@approveShiftSwaps')->name('shiftSwap.approve')->middleware(['auth']);

Route::get('/shift_swap_approve/{shift_swap_id}','AttendanceController@cancelShiftSwaps')->name('shiftSwap.cancel')->middleware(['auth']);

Route::get('/shift_swap_reject/{shift_swap_id}','AttendanceController@rejectShiftSwaps')->name('shiftSwap.reject')->middleware(['auth']);

Route::get('/myshiftswaps','AttendanceController@myShiftSwaps')->name('myShiftSwaps')->middleware(['auth']);

Route::get('/shiftswaps','AttendanceController@shiftSwaps')->name('shiftSwaps')->middleware(['auth']);

// attendance settings end

// workflow

Route::get('workflows/alter-status','WorkflowController@alterStatus')->name('workflows.alter-status')->middleware(['auth']);

Route::resource('workflows', 'WorkflowController',['names'=>['create'=>'workflows.create','index'=>'workflows','store'=>'workflows.save','edit'=>'workflows.edit','update'=>'workflow.update','show'=>'workflows.view','destroy'=>'workflows.delete']])->middleware('auth');

// workflow end

// payroll setting



Route::resource('payrollsettings', 'PayrollSettingController')->middleware(['permission:payroll_setting','auth']);

Route::get('/payrollsetting/attendance_payroll_setting', 'AttendancePayrollController@attendancePayrollSetting')->middleware(['permission:payroll_setting','auth']);

Route::post('/payrollsetting/attendance_payroll_setting', 'AttendancePayrollController@saveAttendancePayrollSettings')->middleware(['permission:payroll_setting','auth'])->name('attendancepayrollsettings.store');

// payroll setting end

// executive view

Route::get('/people_analytics', 'HomeController@executiveView')->name('executive_view')->middleware(['permission:view_hr_reports','auth']);

Route::get('/people_analytics_leave', 'HomeController@executiveViewLeave')->name('executive_view_leave')->middleware(['permission:view_leave_report','auth']);

Route::get('/people_analytics_hr', 'HomeController@executiveViewHR')->name('executive_view_hr')->middleware(['permission:view_attendance_report','auth']);

Route::get('/people_analytics_employee', 'HomeController@executiveViewEmployee')->name('executive_view_attendance')->middleware(['permission:view_attendance_report','auth']);

Route::get('/people_analytics_jobrole', 'HomeController@executiveViewJobRole')->name('executive_view_attendance')->middleware(['permission:view_attendance_report','auth']);

Route::get('/people_analytics_payroll', 'HomeController@executiveViewPayroll')->name('executive_view_attendance')->middleware(['permission:view_attendance_report','auth']);

Route::get('/people_analytics_performance', 'HomeController@executiveViewPerformance')->name('executive_view_performance')->middleware(['permission:view_attendance_report','auth']);

Route::get('/bi-report', 'ReportController@getReport')->name('bi_report')->middleware(['auth']);

// end of executive view

Route::resource('roles', 'RoleController')->middleware(['permission:edit_settings','auth']);

Route::resource('performances', 'PerformanceController')->middleware(['permission:edit_settings','auth']);

Route::resource('performance', 'PerformanceController')->middleware(['permission:edit_settings','auth']);

Route::resource('leave','LeaveController')->middleware(['auth']);

Route::resource('document','DocumentController')->middleware(['auth']);

Route::resource('projects','ProjectController')->middleware(['auth']);

Route::resource('recruits','RecruitController')->middleware(['auth']);

Route::resource('compensation','CompensationController')->middleware(['auth']);

Route::resource('loan','LoanController')->middleware(['auth']);

Route::get('jobs_departments','JobController@departments')->name('job_departments.view')->middleware(['auth']);

Route::get('job_skill_search','JobController@skill_search')->middleware(['auth']);

Route::get('job_search','JobController@job_search')->middleware(['auth']);

Route::get('job_qualification_search','JobController@qualification_search')->middleware(['auth']);

Route::get('joblist/{department_id}', 'JobController@list')->name('job_list.view')->middleware(['auth']);

Route::get('jobs/department/{department_id}','JobController@index')->middleware(['auth']);

Route::get('jobs/create/{department_id}','JobController@create')->middleware(['auth'])->name('jobs.create');

Route::get('jobs/delete/{job_id}','JobController@delete')->middleware(['auth'])->name('jobs.delete');

Route::get('job_search','JobController@job_search')->middleware(['auth']);

Route::resource('jobs', 'JobController',['names'=>['store'=>'jobs.save','edit'=>'jobs.edit','update'=>'jobs.update','show'=>'jobs.view','destroy'=>'jobs.delete']])->except([

    'index', 'create'])->middleware('auth');

Route::get('location/country','HomeController@countries')->middleware(['auth']);

Route::get('location/state/{country_id}','HomeController@states')->middleware(['auth']);

Route::get('location/lga/{state_id}','HomeController@lgas')->middleware(['auth']);



//OAuth

Route::get('/auth/microsoft', 'MicrosoftController@redirectToProvider');

Route::get('/auth/microsoft/callback', 'MicrosoftController@callbackurl');



Route::resource('bscsettings', 'BSCController')->middleware(['auth']);

Route::get('bsc/usersearch', 'BSCEvaluationController@usersearch')->middleware(['auth']);

Route::resource('bsc', 'BSCEvaluationController')->middleware(['auth']);



Route::resource('e360settings', 'E360SettingController')->middleware(['auth']);

Route::get('e360/usersearch', 'E360Controller@usersearch')->middleware(['auth']);

Route::resource('e360', 'E360Controller')->middleware(['auth']);





/*************Payroll Module Start******************/





/*************Payroll Module End******************/



/***************Leave Management Module Start***********/



/***************Leave Management Module End***********/





/*************Attendance and Leave Module Start******************/







 //NEW TRAINING MODULE ROUTES

Route::get('/training', 'TrainingController@index')->name('index')->middleware(['auth']);

Route::get('/newtraining', 'TrainingController@newtraining')->name('training')->middleware(['auth']);

Route::get('/training/create', 'TrainingController@create_training')->name('create_training')->middleware('auth');

Route::get('/training/edit/{id}', 'TrainingController@edit_training')->name('edit_training')->middleware('auth');

Route::get('/training/edit-training/{id}', 'TrainingController@edit_ongoing_training')->name('edit_ongoing_training')->middleware('auth');

Route::post('/training/save_training', 'TrainingController@save_training')->name('save_training')->middleware('auth');

Route::get('/training/view/{id}', 'TrainingController@view_training')->name('view_training')->middleware('auth');

Route::get('/training/info', 'TrainingController@training_info')->name('training_info')->middleware('auth');

Route::post('/training/save_start_training', 'TrainingController@save_start_training')->name('save_start_training')->middleware('auth');



Route::post('/training/save_training_user', 'TrainingController@save_training_user')->name('save_training_user')->middleware('auth');

Route::post('/training/save_training_group', 'TrainingController@save_training_group')->name('save_training_group')->middleware('auth');

Route::get('/training/delete_training_user', 'TrainingController@delete_training_user')->name('delete_training_user')->middleware('auth');

Route::get('/training/approve_training_user', 'TrainingController@approve_training_user')->name('approve_training_user')->middleware('auth');

Route::get('/training/decline_training_user', 'TrainingController@decline_training_user')->name('decline_training_user')->middleware('auth');

Route::post('/training/add_budget_to_training', 'TrainingController@add_budget_to_training')->name('add_budget_to_training')->middleware('auth');



Route::get('/training/budget', 'TrainingController@budget')->name('training.budget')->middleware('auth');

Route::get('/training/budget/create', 'TrainingController@create_budget')->name('create_budget')->middleware('auth');

Route::get('/training/budget/edit/{id}', 'TrainingController@edit_budget')->name('edit_budget')->middleware('auth');

Route::post('/training/budget/save_budget', 'TrainingController@save_budget')->name('save_budget')->middleware('auth');

Route::get('/training/budget/view/{id}', 'TrainingController@view_budget')->name('view_budget')->middleware('auth');



Route::get('/mytraining', 'TrainingController@my_training')->name('my.training')->middleware('auth');







//AJAX

Route::get('/getTraineeDetails', 'TrainingController@getTraineeDetails');

Route::resource('unions', 'UnionController')->middleware(['auth']);

Route::resource('sections', 'SectionController')->middleware(['auth']);

Route::resource('notifications', 'NotificationController')->middleware(['auth']);

Route::resource('query', 'QueryController')->middleware(['auth']);

Route::resource('probation', 'ProbationPolicyController')->middleware(['auth']);



//facial verification

Route::post('users/face/search','UserController@postFacesearch')->name('users.face.post')->middleware(['auth']);

Route::resource('document_requests', 'DocumentRequestController')->middleware(['auth']);
Route::resource('postings', 'PostingController')->middleware(['auth']);

///Microsoft HCMatrix Chatbot





Route::post('process-ajax-command/{cmd}','CommandController@processAjaxAction')->name('process.ajax.command');

Route::get('process-ajax-command/{cmd}','CommandController@processAjaxAction')->name('process.ajax.command');

Route::post('process-action-command/{cmd}','CommandController@processAction')->name('process.action.command');

Route::get('app-get/{cmd}','FrontEndController@processGet')->name('app.get')->middleware(['auth']);

Route::resource('audits', 'AuditController')->middleware(['auth','permission:view_audit_report']);

Route::resource('company_documents', 'CompanyDocumentController')->middleware(['auth']);

    Route::resource('employee_reimbursements', 'EmployeeReimbursementController')->middleware(['auth']);

    Route::get('/settings/system/switchlogpolicy', 'SystemSettingController@switchLogPolicy')->name('systemsettings.switchlogpolicy')->middleware(['permission:edit_settings','auth']);

    Route::resource('organograms', 'CompanyOrganogramController')->middleware(['auth']);



});



//calculate late policy

Route::get('/calculate/attendance/lateness', 'AttendanceReportController@calculateLateness')->name('calculate.lateness')->middleware(['permission:run_payroll','auth']);



//medical history

Route::post('/medical/store', 'MedicalHistoryController@store')->name('medical.history.store')->middleware(['auth']);

Route::get('/medical/store', 'MedicalHistoryController@store')->name('medical.history.store')->middleware(['auth']);

//polls

Route::get('/polls', 'PollController@polls')->name('view.polls')->middleware(['permission:take_poll','auth']);

Route::get('/my-polls', 'PollController@my_polls')->name('view.my.polls')->middleware(['permission:take_poll','auth']);

Route::get('/poll/respond/{id}', 'PollController@respond')->name('respond.poll')->middleware(['permission:take_poll','auth']);

Route::post('/poll/respond', 'PollController@submitResponse')->name('submit.response')->middleware(['permission:take_poll','auth']);

Route::get('/poll/responses/{id}', 'PollController@pollResponses')->name('poll.responses')->middleware(['permission:create_poll','auth']);

Route::get('/poll/create', 'PollController@createPoll')->name('create.poll')->middleware(['permission:create_poll','auth']);

Route::get('/poll/edit/{id}', 'PollController@editPoll')->name('edit.poll')->middleware(['permission:create_poll','auth']);

Route::post('/poll/create', 'PollController@storePoll')->name('store.poll')->middleware(['permission:create_poll','auth']);

Route::patch('/poll/update/{id}', 'PollController@updatePoll')->name('update.poll')->middleware(['permission:create_poll','auth']);

Route::get('/poll/change-status/{poll}/{status}', 'PollController@changePollStatus')->name('poll.change.status')->middleware(['permission:create_poll','auth']);

Route::post('/poll/voted-users', 'PollController@votedUsers')->name('poll.voted.users')->middleware(['permission:take_poll','auth']);





///Microsoft HCMatrix Chatbot

Route::get('/botHandler', function(){

    return view('bot/bot');

});



Route::get('/getBotLeaveInfo', 'Bot@getLeaveInfo');

Route::get('/postBotsaveRequest', 'Bot@saveRequest');

Route::get('/getMyInfo', 'Bot@getMyInfo');

Route::get('/getCalendar/', 'Bot@getCalendar');













///////////FERMA VOTING MODULE//////

Route::get('allvotesettings', 'VoteController@allvotesettings')->middleware(['auth','vote_settings']);

Route::get('=SW5kaXZpZHVhbCBBV0FSRA==/{id}', 'VoteController@switch');



///READ/CREATE [3]AWARD CATEGORIES////

Route::get('votecat', 'VoteController@showvotecategories')->middleware(['auth','vote_settings']);



///READ/CREATE/SELECT AWARD YEAR/////

Route::get('awardsyear', 'VoteController@awardsyear')->name('awardsyear')->middleware(['auth','vote_settings']);

Route::post('cawardsyear', 'VoteController@CreateYear')->name('cawardsyear')->middleware(['auth','vote_settings']);

Route::get('selectyear', 'VoteController@SelectYear')->name('selectyear')->middleware(['auth','vote_settings']);



///READ/CREATE/SELECT AWARDS///////

Route::get('awards', 'VoteController@awards')->name('awards')->middleware(['auth','vote_settings']);

Route::post('cawards', 'VoteController@CreateOrUpdate')->name('createaward')->middleware(['auth','vote_settings']);

Route::get('deletevoteaward', 'VoteController@deleteVoteAward')->middleware(['auth','vote_settings']);



///READ/CREATE/DELETE AWARD-CATEGORY ATTRIBUTES////

Route::get('attributes', 'VoteController@awardsattributes')->name('attributes')->middleware(['auth','vote_settings']);

Route::post('updateattr', 'VoteController@CreateOrUpdateAttr')->middleware(['auth','vote_settings']);

Route::get('deletevoteattr', 'VoteController@deletevoteattr')->middleware(['auth','vote_settings']);



////VOTING WEIGHT CONFIGURATION

Route::get('configurations', 'VoteController@awardattributes_config')->name('configurations')->middleware(['auth','vote_settings']);

Route::get('configset', 'VoteController@awardattributes_config_update')->middleware(['auth','vote_settings']);



/////VOTE STARTMENU

Route::get('startmenu', 'VoteController@votestartmenu')->middleware('auth');



////INDIVIDUAL AND TEAM AWARD VOTING/////

Route::get('vote/{user}', 'VoteController@voteByUser');

Route::get('votegrp/{user}', 'VoteController@voteByGroup');

Route::get('votesearch', 'VoteController@searchemployees');

Route::post('votecandidate', 'VoteController@votecandidate');



////INDIVIDUAL AND TEAM AWARD REPORTING/////

Route::get('votereport', 'VoteController@votereport')->middleware(['auth','vote_report']);

Route::get('uservotereport/{user_id}/{votecat_id}', 'VoteController@uservotereport')->middleware(['auth','vote_report']);

Route::get('allusersvotereport', 'VoteController@allusersvotereport')->middleware(['auth','vote_report']);

Route::get('merit-award', 'VoteController@merit_award')->middleware(['auth','vote_report']);



////INDIVIDUAL AND TEAM AWARD ELIGIBILTY CONFIGURATION/////

Route::get('eligibility', 'VoteController@eligibility')->middleware(['auth','vote_settings']);

Route::post('eligibility', 'VoteController@eligibility_submit')->middleware(['auth','vote_settings']);

Route::get('eligiblevotersmodal', 'VoteController@eligiblevotersmodal')->name('eligiblevotersmodal')->middleware(['auth','vote_settings']);



///////////END FERMA VOTING MODULE//////





Route::get('/promotions', 'PerformanceController@promotionlist');









Route::get('/promotion-module', 'PromotionController@module')->name('promotions.index')->middleware(['permission:upload_promotion_list','auth']);



Route::get('/promotion-by-exam', 'PromotionController@promotionsByExam')->name('promotion.by.exam')->middleware(['permission:upload_promotion_list','auth']);

Route::get('/promotion-by-advancement', 'PromotionController@promotionsByAdvancement')->name('promotion.by.advancement')->middleware(['permission:upload_promotion_list','auth']);

Route::get('/generate-eligible', 'PromotionController@populateEligibleStaff')->name('populate.eligible')->middleware(['permission:upload_promotion_list','auth']);

Route::get('/promotions_import', 'PromotionController@downloadTemplate')->name('promotion.template')->middleware(['permission:upload_promotion_list','auth']);

Route::post('/promotions_import', 'PromotionController@importTemplate')->name('promotion.template.import')->middleware(['permission:upload_promotion_list','auth']);

Route::post('/approve_promotions', 'PromotionController@promote')->name('approve.promotions')->middleware(['permission:upload_promotion_list','auth']);

Route::get('/promotion/rank/year', 'PromotionController@loadRankPromotions')->name('promotion.rank.year')->middleware(['permission:upload_promotion_list','auth']);

Route::get('/promotion/export/data', 'PromotionController@exportPromotionDetails')->name('export.promotion.details')->middleware(['permission:upload_promotion_list','auth']);



//exam score

/*

Route::get('/exam/scores', 'ExamScoreController@examScores')->name('exam.scores')->middleware(['permission:upload_exam_score','auth']);

Route::get('/exam/scores-template', 'ExamScoreController@examScoresTemplate')->name('exam.stores.template')->middleware(['permission:upload_exam_score','auth']);

Route::post('/exam/scores/import', 'ExamScoreController@examScoresImport')->name('exam.scores.import')->middleware(['permission:upload_exam_score','auth']);*/



//host

Route::get('/visitor/dashboard', 'VisitorController@dashboard')->name('visitor.dashboard')->middleware(['permission:book_visit','auth']);

Route::get('/visitor/book-visit', 'VisitorController@book_visit')->name('visitor.book.visit')->middleware(['permission:book_visit','auth']);

Route::get('/visitor/manage-visitor', 'VisitorController@my_visitors')->name('visitor.my.visitors')->middleware(['permission:book_visit','auth']);

Route::get('/visitor/visitor-history', 'VisitorController@visitor_history')->name('visitor.visitor.history')->middleware(['permission:book_visit','auth']);

Route::resource('apersettings', 'AperSettingController')->middleware(['auth']);

Route::resource('aper', 'AperController')->middleware(['auth']);









////new divide////////////

Route::post('call-service/{service}','CommandControllerV2@runAutomatedCommand')->name('call.service');

Route::get('call-service/{service}','CommandControllerV2@runAutomatedCommand')->name('call.service');

Route::get('training-get/{route}','TrainingFrontController@runCommand')->name('training.get')->middleware(['auth']);

Route::get('ajax-search-user',function(){



	if (request()->filled('search')){

		$search = request('search');

	}else{

		$search = request('search');

	}



	return (new \App\User)->ajaxSearchUser($search);



})->name('ajax.search.user');

Route::resource('cadres', 'CadreController')->middleware(['auth']);

Route::resource('zones', 'ZoneController')->middleware(['auth']);

Route::resource('pfas', 'PFAController')->middleware(['auth']);

Route::get('users/cadre/ranks/{cadre_id}','UserController@getCadreRanks')->middleware(['permission:edit_user_advanced','auth']);

Route::get('users/zone/field_offices/{zone_id}','UserController@getZoneFieldOffices')->middleware(['permission:edit_user_advanced','auth']);

Route::get('users/department/divisions/{department_id}','UserController@getDepartmentDivisions')->middleware(['permission:edit_user_advanced','auth']);

Route::get('groups/assignrole','UserGroupController@assignRole')->name('groups.assignrole')->middleware(['auth','permission:manage_user']);





Route::post('/settings/integration/save_policy', 'SystemSettingController@saveIntegrationPolicy')->middleware(['permission:edit_settings','auth'])->name('integration_policy.store');

Route::get('/systemsettings/generate_app_key/', 'SystemSettingController@generateAppKey');





//admin

Route::get('/visitor/admin-dashboard', 'VisitorController@admin_dashboard')->name('visitor.admin.dashboard')->middleware(['permission:admin_dashboard','auth']);

Route::get('/visitor/admin-visitor-history', 'VisitorController@admin_visitor_history')->name('visitor.admin.visitor.history')->middleware(['permission:admin_dashboard','auth']);

Route::get('/visitor/admin-manage-history', 'VisitorController@admin_manage_visitor')->name('visitor.admin.manage.history')->middleware(['permission:admin_dashboard','auth']);





//front desk

Route::get('/visitor/front/dashboard', 'VisitorController@front_dashboard')->name('visitor.front.dashboard');

Route::get('visitor/front/book-visit', 'VisitorController@front_bookVisit')->name('visitor.front.book.visit');




////new divide////////////
Route::post('call-service/{service}','CommandControllerV2@runAutomatedCommand')->name('call.service');
Route::get('call-service/{service}','CommandControllerV2@runAutomatedCommand')->name('call.service');
Route::get('training-get/{route}','TrainingFrontController@runCommand')->name('training.get')->middleware(['auth']);
Route::get('ajax-search-user',function(){

	if (request()->filled('search')){
		$search = request('search');
	}else{
		$search = request('search');
	}

	return (new \App\User)->ajaxSearchUser($search);

})->name('ajax.search.user');


Route::resource('man_power_training', 'ManPowerTrainingController')->middleware(['auth']);
Route::resource('man_power_training_approval','ManPowerTrainingApprovalController')->middleware(['auth']);



Route::get('migrate',function(){

	\Illuminate\Support\Facades\Artisan::call('migrate');

	return [
		'message'=>'Tables migrated',
		'error'=>false
	];

//	stdClass

});