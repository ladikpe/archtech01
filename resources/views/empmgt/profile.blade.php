@extends('layouts.master')
@section('stylesheets')


    <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-table/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
    <style type="text/css">
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            text-align: center;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
            background: #333;
        }


    </style>
@endsection
@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">User Profile</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{Auth::user()->role->permissions->contains('constant', 'manage_user')? url('users'):"javascript:void(0)"}}">Employee Management</a></li>
                <li class="breadcrumb-item active">User Profile</li>
            </ol>
            <div class="page-header-actions">
                @if($user->id==Auth::user()->id)
                    <button type="button" data-target="#changePasswordModal" data-toggle="modal" id="changePassword" class="btn  btn-primary"  >
                        Change Password
                    </button>
                @endif
                @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))



                    <button type="button" data-target="#addSeparationModal" data-toggle="modal" id="separateUser" class="btn  btn-primary"  >
                        Separate User
                    </button>

                    @if($user->suspensions()->whereDate('startdate','<=',date('Y-m-d'))->whereDate('enddate','>=',date('Y-m-d'))&&$user->id==Auth::user()->id)

                    @else
                        <button type="button" data-target="#addSuspensionModal" data-toggle="modal" id="suspendUser" class="btn  btn-primary"  >
                            Suspend User
                        </button>
                    @endif
                @endif
            </div>
        </div>
        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <!-- Panel -->
                    <div class="panel">

                        <div class="panel-body nav-tabs-animate nav-tabs-horizontal" data-plugin="tabs" id="tabs">
                            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="active nav-link" data-toggle="tab"
                                       href="#personal" aria-controls="activities" role="tab">Personal Information </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#direct_reports" aria-controls="messages" role="tab">Manager(s)/Direct Report(s)</a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#experience" aria-controls="messages" role="tab">Work History</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#academics" aria-controls="profile" role="tab">Academic History</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#dependants" aria-controls="messages" role="tab">Dependants</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#skills" aria-controls="messages" role="tab">Skills</a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#query_history" aria-controls="messages" role="tab">Query History</a>
                                </li>
                                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#offline-training-history" aria-controls="profile"
                                                                            role="tab">Training History</a></li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#user_groups" aria-controls="messages" role="tab">User Groups</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#medical_history" aria-controls="messages" role="tab">Medical History</a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                {{-- PERSONAL INFORMATION --}}
                                <div class="tab-pane active animation-slide-left" id="personal" role="tabpanel">
                                    <br>
                                    <form enctype="multipart/form-data" id="emp-data" method="POST" onsubmit="">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label>Upload Image</label>
                                                    <img class="img-circle img-bordered img-bordered-blue text-center" width="150" height="150" src="{{ file_exists(public_path('uploads/avatar'.$user->image))?asset('uploads/avatar'.$user->image):($user->sex=='M'?asset('global/portraits/male-user.png'):asset('global/portraits/female-user.png'))}}" alt="..." id='img-upload'>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <div class="input-group">
                      <span class="input-group-btn">
                          <span class="btn btn-default btn-file">
                             Browse… <input  style="width:300px" type="file" id="imgInp" name="avatar" accept="image/*">
                          </span>
                      </span>
                                                            <input type="text" class="form-control" readonly>
                                                        </div>
                                                    @endif
                                                </div>




                                            </div>

                                            <br>

                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Name</label>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control" id="name" value="{{$user->name}}" name="name" placeholder="Name"
                                                               required />
                                                    @else
                                                        <input type="text" class="form-control"  placeholder="{{$user->name}}" disabled>
                                                        <input type="hidden" name="bank_id" value="{{$user->name}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Employee Number </label>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control" id="emp_num" value="{{$user->emp_num}}" name="emp_num" placeholder="Employee Number"      required/>
                                                    @else
                                                        <input type="text" class="form-control"  placeholder="{{$user->emp_num}}" disabled>
                                                        <input type="hidden" name="emp_num" value="{{$user->emp_num}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Email</label>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="email" class="form-control" id="email" value="{{$user->email}}" name="email" placeholder="Email"
                                                        />
                                                    @else
                                                        <input type="text" class="form-control"  placeholder="{{$user->email}}" disabled>
                                                        <input type="hidden" name="email" value="{{$user->email}}">
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Phone Number</label>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control" id="phone" value="{{$user->phone}}" name="phone" placeholder="Phone Number"
                                                        />
                                                    @else
                                                        <input type="text" class="form-control"  placeholder="{{$user->phone}}" disabled>
                                                        <input type="hidden" name="phone" value="{{$user->phone}}">
                                                    @endif
                                                </div>

                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Gender</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control" id="sex" name="sex">
                                                            <option value="M" {{$user->sex=='M'?'selected':''}}>Male</option>
                                                            <option value="F" {{$user->sex=='F'?'selected':''}}>Female</option>
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="sex" placeholder="{{$user->sex=='M'?'Male':'Female'}}" disabled>
                                                        <input type="hidden" name="sex" value="{{$user->sex}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Marital Status</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control" id="marital_status" name="marital_status">
                                                            <option value="Single" {{$user->marital_status=='Single'?'selected':''}}>Single</option>
                                                            <option value="Married" {{$user->marital_status=='Married'?'selected':''}}>Married</option>
                                                            <option value="Divorced" {{$user->marital_status=='Divorced'?'selected':''}}>Divorced</option>
                                                            <option value="Separated" {{$user->marital_status=='Separated'?'selected':''}}>Separated</option>
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="marital_status" placeholder="{{$user->marital_status}}" disabled>
                                                        <input type="hidden" name="marital_status" value="{{$user->marital_status}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Date of Birth(year-month-day)</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control  {{Auth::user()->role->permissions->contains('constant', 'edit_user_advanced')?'datepicker':''}} "  id="dob" name="dob" placeholder="Phone Number"
                                                               value="{{date("Y-m-d",strtotime($user->dob))}}"  />
                                                    @else
                                                        <input type="text" class="form-control" name="dob" placeholder="{{date("m/d/Y",strtotime($user->dob))}}" disabled>
                                                        <input type="hidden" name="dob" value="{{date("Y-m-d",strtotime($user->dob))}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Address</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <textarea class="form-control" id="address" name="address" rows="3" {{Auth::user()->role->permissions->contains('constant', 'edit_user_advanced')?'':'readonly'}}>{{$user->address}}</textarea>
                                                    @else
                                                        <textarea class="form-control" id="address" name="address" rows="3" disabled placeholder="{{$user->address}}"></textarea>
                                                        <input type="hidden" name="address" value="{{$user->address}}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Confirmation Date(year-month-day)</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control {{Auth::user()->role->permissions->contains('constant', 'edit_user_advanced')?'datepicker':''}}"  id="confirmation_date" name="confirmation_date" placeholder="Confirmation Date"
                                                               value="{{date("Y-m-d",strtotime($user->confirmation_date))}}" {{Auth::user()->role->permissions->contains('constant', 'edit_user_advanced')?'':'readonly'}} />
                                                    @else
                                                        <input type="text" class="form-control" name="confirmation_date" placeholder="{{date("m/d/Y",strtotime($user->confirmation_date))}}" disabled>
                                                        <input type="hidden" name="confirmation_date" value="{{date("Y-m-d",strtotime($user->confirmation_date))}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Date of First Appointment(year-month-day)</label>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control {{Auth::user()->role->permissions->contains('constant', 'edit_user_advanced')?'datepicker':''}}"  id="hiredate" name="hiredate" placeholder="Hire Date" value="{{$user->hiredate?date('Y-m-d',strtotime($user->hiredate)):''}}"
                                                        />
                                                    @else
                                                        <input type="text" class="form-control" name="hiredate" placeholder="{{date("Y-m-d",strtotime($user->hiredate))}}" disabled>
                                                        <input type="hidden" name="hiredate" value="{{date("Y-m-d",strtotime($user->hiredate))}}">
                                                    @endif
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Date of Present Appointment(year-month-day)</label>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control {{Auth::user()->role->permissions->contains('constant', 'edit_user_advanced')?'datepicker':''}}"  id="date_of_present_appointment" name="date_of_present_appointment" placeholder="" value="{{$user->date_of_present_appointment?date('Y-m-d',strtotime($user->date_of_present_appointment)):''}}"
                                                        />
                                                    @else
                                                        <input type="text" class="form-control" name="date_of_present_appointment" placeholder="{{date("Y-m-d",strtotime($user->date_of_present_appointment))}}" disabled>
                                                        <input type="hidden" name="date_of_present_appointment" value="{{date("Y-m-d",strtotime($user->date_of_present_appointment))}}">
                                                    @endif
                                                </div>
                                            </div>
                                            {{--
                                            <div class="col-md-4">
                                                <div class="form-group form-material " data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Payroll Type</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control" id="payroll_type" name="payroll_type">
                                                            <option value="office" {{$user->payroll_type=='office'?'selected':''}}>Office Payroll</option>
                                                            <option value="tmsa" {{$user->payroll_type=='tmsa'?'selected':''}}>TMSA</option>
                                                            <option value="project" {{$user->payroll_type=='project'?'selected':''}}>Project</option>
                                                            <option value="attendance" {{$user->payroll_type=='attendance'?'selected':''}}>Attendance Based</option>
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="payroll_type" placeholder="{{ucfirst($user->payroll_type)}}" disabled>
                                                        <input type="hidden" name="payroll_type" value="{{$user->payroll_type}}">
                                                    @endif
                                                </div>
                                            </div>
--}}
                                            <div class="col-md-4">
                                                <div class="form-group form-material " data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Probation End Date</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control datepicker_noprevious"  name="probation_period" placeholder="{{$user->probation_period}}" readonly>
                                                    @else
                                                        <input type="text" class="form-control" name="probation_period" placeholder="{{$user->probation_period}}" disabled>
                                                        <input type="hidden" name="probation_period" value="{{$user->probation_period}}">
                                                    @endif
                                                </div>
                                            </div>

                                            {{--                                    <div class="col-md-4">--}}
                                            {{--                                       @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))--}}
                                            {{--                                            <div class="form-group form-material p-cont" data-plugin="formMaterial">--}}
                                            {{--                                             <label class="form-control-label" for="select">Project Payroll Category</label>--}}
                                            {{--                                             <select class="form-control p-elt selector" id="project_salary_category" name="project_salary_category">--}}
                                            {{--                                               @foreach($project_salary_categories as $category)--}}
                                            {{--                                               <option value="{{$category->id}}" {{$user->project_salary_category_id==$category->id?'selected':''}}>{{$category->name}}({{$category->basic_salary}})</option>--}}
                                            {{--                                               @endforeach--}}
                                            {{--                                             </select>--}}
                                            {{--                                               </div>--}}
                                            {{--                                         @else--}}
                                            {{--                                          @if($user->payroll_type=='project')--}}
                                            {{--                                          <input type="text" class="form-control" name="project_salary_category" placeholder="{{ucfirst($user->project_salary_category->name)}}" disabled>--}}
                                            {{--                                          <input type="hidden" name="project_salary_category" value="{{$user->project_salary_category->id}}">--}}
                                            {{--                                          @endif--}}
                                            {{--                                         @endif--}}
                                            {{--                                             </div>--}}
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Country</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control " id="country" name="country" >
                                                            @if($user->country)
                                                                <option value="{{$user->country->id}}">{{$user->country->name}}</option>
                                                            @endif
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="country" placeholder="{{ucfirst($user->country?$user->country->name:'')}}" disabled>
                                                        <input type="hidden" name="country" value="{{$user->country?$user->country->id:''}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">State/Region</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control " id="state" name="state"  >
                                                            @if($user->state)
                                                                <option value="{{$user->state->id}}">{{$user->state->name}}</option>
                                                            @endif
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="state" placeholder="{{ucfirst($user->state?$user->state->name:'')}}" disabled>
                                                        <input type="hidden" name="state" value="{{$user->state?$user->state->id:''}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">LGA/ District</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control " id="lga" name="lga" >
                                                            @if($user->lga)
                                                                <option value="{{$user->lga->id}}">{{$user->lga->name}}</option>
                                                            @endif
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="lga" placeholder="{{ucfirst($user->lga?$user->lga->name:'')}}" disabled>
                                                        <input type="hidden" name="lga" value="{{$user->lga?$user->lga->id:''}}">
                                                    @endif
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="company_id">Zone</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select id="zone_id" name="zone_id" onchange="zoneChange(this.value);" class="form-control select2"  style="width: 100%">
                                                            <option></option>
                                                            @foreach($zones as $zone)
                                                                @if($user->field_office)
                                                                    <option value="{{$zone->id}}" {{$user->field_office->zone_id==$zone->id?'selected':''}}>{{$zone->name}}</option>
                                                                @else
                                                                    <option value="{{$zone->id}}">{{$zone->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        @if($user->field_office)
                                                            <input type="text" class="form-control" name="zone_id" placeholder="{{$user->field_office->zone->name}}" disabled>
                                                            <input type="hidden" name="zone_id" value="{{$user->field_office->zone_id}}">
                                                        @else
                                                            <input type="text" class="form-control" name="zone_id" placeholder="No Zone" disabled>
                                                            <input type="hidden" name="zone_id" value="{{$user->cadre_id}}">
                                                        @endif

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Field Office</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control select2" id="field_offices"   name="field_office_id"  style="width: 100%">

                                                            @if($user->field_office)
                                                                <option value="0">Please select field office</option>
                                                                @if($user->field_office->zone)

                                                                @foreach($user->field_office->zone->field_offices as $field_office)
                                                                    <option value="{{$field_office->id}}" {{$field_office->id==$user->field_office_id?'selected':''}}>{{$field_office->name}}</option>
                                                                @endforeach
                                                                @endif
                                                            @else

                                                                <option value="0">Please select zone</option>

                                                            @endif
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="field_office_id" placeholder="{{ucfirst($user->field_office?$user->field_office->name:'')}}" disabled>
                                                        <input type="hidden" name="field_office_id" value="{{$user->field_office_id}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Department</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control select2" id="department_id"   name="department_id"  onchange="departmentDivisionChange(this.value);" style="width: 100%">
                                                            @foreach($departments as $department)

                                                                <option value="{{$department->id}}" {{$user->department_id==$department->id?"selected":""}}>{{$department->name}}</option>

                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control " disabled  id="department_id" name="department_id" placeholder="{{$user->department?$user->department->name:''}}"
                                                        />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Division </label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control select2" id="divisions"   name="division_id"  style="width: 100%">

                                                            @if($user->division && $user->division != null)
                                                                <option value="0">Please select Division</option>

                                                                @foreach($user->division->department->divisions as $division)
                                                                    <option value="{{$division->id}}" {{$division->id==$user->division_id?'selected':''}}>{{$division->name}}</option>
                                                                @endforeach
                                                            @else

                                                                <option value="0">Please select department</option>

                                                            @endif
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="division_id" placeholder="{{ucfirst($user->division?$user->division->name:'')}}" disabled>
                                                        <input type="hidden" name="division_id" value="{{$user->division_id}}">
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Cadre</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select id="cadre_id" name="cadre_id" onchange="cadreChange(this.value);" class="form-control select2"  style="width: 100%">
                                                            <option></option>
                                                            @foreach($cadres as $cadre)
                                                                @if($user->rank)
                                                                    <option value="{{$cadre->id}}" {{$user->rank->cadre_id==$cadre->id?'selected':''}}>{{$cadre->name}}</option>
                                                                @else
                                                                    <option value="{{$cadre->id}}">{{$cadre->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        @if($user->rank)
                                                            <input type="text" class="form-control" name="cadre_id" placeholder="{{$user->cadre->name}}" disabled>
                                                            <input type="hidden" name="cadre_id" value="{{$user->cadre_id}}">
                                                        @else
                                                            <input type="text" class="form-control" name="cadre_id" placeholder="No Cadre" disabled>
                                                            <input type="hidden" name="cadre_id" value="{{$user->cadre_id}}">
                                                        @endif

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Rank</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control select2" id="ranks"   name="rank_id"  style="width: 100%">

                                                            @if($user->rank)
                                                                <option value="0">Please select rank</option>
                                                                @if($user->cadre)
                                                                    @foreach($user->cadre->ranks as $rank)
                                                                        <option value="{{$rank->id}}" {{$rank->id==$user->rank_id?'selected':''}}>{{$rank->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="0">Please select rank</option>
                                                                @endif
                                                            @else

                                                                <option value="0">Please select rank</option>

                                                            @endif
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="rank_id" placeholder="{{ucfirst($user->rank?$user->rank->name:'')}}" disabled>
                                                        <input type="hidden" name="rank_id" value="{{$user->rank_id}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Grade</label>
                                                    <input type="text" class="form-control " disabled  id="inputText" name="inputText" placeholder="{{$user->rank?($user->rank->grade?$user->rank->grade->level:''):''}}"
                                                    />
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">

                                            <h4 style="padding-left: 15px;">Pension Account Details</h4>

                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Pension Fund Administrator</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control" id="pension_fund_administrator_id"  name="pension_fund_administrator_id">
                                                            <option value="0"></option>
                                                            @foreach ($pfas as $pfa)
                                                                <option value="{{$pfa->id}}" {{$user->pension_fund_administrator_id==$pfa->id?'selected':''}}>{{$pfa->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="pension_fund_administrator_id" placeholder="{{$user->pension_fund_administrator?$user->pension_fund_administrator->name:''}}" disabled>
                                                        <input type="hidden" name="pension_fund_administrator_id" value="{{$user->pension_fund_administrator_id}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Pension Account Number</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control "  value="{{$user->pension_account_no}}"  id="pension_account_no" name="pension_account_no" placeholder="Pension Account Number"
                                                        />
                                                    @else
                                                        <input type="text" class="form-control" name="pension_account_no" placeholder="{{$user->pension_account_no}}" disabled>
                                                        <input type="hidden" name="pension_account_no" value="{{$user->pension_account_no}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <h4 style="padding-left: 15px;">Account Details</h4>

                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Bank</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control" id="bank_id"  name="bank_id">
                                                            @foreach ($banks as $bank)
                                                                <option value="{{$bank->id}}" {{$user->bank_id==$bank->id?'selected':''}}>{{$bank->bank_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="bank_id" placeholder="{{$user->bank?$user->bank->bank_name:''}}" disabled>
                                                        <input type="hidden" name="bank_id" value="{{$user->bank_id}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Account Number</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control "  value="{{$user->bank_account_no}}"  id="account_no" name="bank_account_no" placeholder="Account Number"
                                                        />
                                                    @else
                                                        <input type="text" class="form-control" name="bank_account_no" placeholder="{{$user->bank_account_no}}" disabled>
                                                        <input type="hidden" name="bank_account_no" value="{{$user->bank_account_no}}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h4 style="padding-left: 15px;">Next of Kin</h4>
                                            <div class="col-md-4">
                                                <input type="hidden" name="nok_id" value="{{$user->nok()->count()>0?$user->nok->id:''}}">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Name</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control "   id="nok_name" value="{{$user->nok()->count()>0?$user->nok->name:''}}" name="nok_name" placeholder="Name" {{Auth::user()->role->permissions->contains('constant', 'edit_user_advanced')?'':'readonly'}}
                                                        />
                                                    @else
                                                        <input type="text" class="form-control" name="nok_name" placeholder="{{$user->nok?$user->nok->name:''}}" disabled>
                                                        <input type="hidden" name="nok_name" value="{{$user->nok?$user->nok->nok_name:''}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="select">Relationship</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <select class="form-control" id="nok_relationship"  name="nok_relationship" >
                                                            <option value="spouse" {{$user->nok?($user->nok->relationship=='spouse'?'selected':''):''}}>Spouse</option>
                                                            <option value="husband" {{$user->nok?($user->nok->relationship=='husband'?'selected':''):''}}>Husband</option>
                                                            <option value="wife" {{$user->nok?($user->nok->relationship=='wife'?'selected':''):''}}>Wife</option>
                                                            <option value="father" {{$user->nok?($user->nok->relationship=='father'?'selected':''):''}}>Father</option>
                                                            <option value="mother" {{$user->nok?($user->nok->relationship=='mother'?'selected':''):''}}>Mother</option>
                                                            <option value="brother" {{$user->nok?($user->nok->relationship=='brother'?'selected':''):''}}>Brother</option>
                                                            <option value="sister" {{$user->nok?($user->nok->relationship=='sister'?'selected':''):''}}>Sister</option>
                                                            <option value="nephew" {{$user->nok?($user->nok->relationship=='nephew'?'selected':''):''}}>Nephew</option>
                                                            <option value="niece" {{$user->nok?($user->nok->relationship=='niece'?'selected':''):''}}>Niece</option>
                                                            <option value="uncle" {{$user->nok?($user->nok->relationship=='uncle'?'selected':''):''}}>Uncle</option>
                                                            <option value="aunt" {{$user->nok?($user->nok->relationship=='aunt'?'selected':''):''}}>Aunt</option>
                                                            <option value="son" {{$user->nok?($user->nok->relationship=='son'?'selected':''):''}}>Son</option>
                                                            <option value="daughter" {{$user->nok?($user->nok->relationship=='daughter'?'selected':''):''}}>Daughter</option>
                                                            <option value="friend" {{$user->nok?($user->nok->relationship=='friend'?'selected':''):''}}>Friend</option>
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control" name="nok_relationship" placeholder="{{$user->nok?ucfirst($user->nok->relationship):''}}" disabled>
                                                        <input type="hidden" name="nok_relationship" value="{{$user->nok?$user->nok->relationship:''}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Phone Number</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <input type="text" class="form-control "  id="nok_phone" name="nok_phone" value="{{$user->nok()->count()>0?$user->nok->phone:''}}"  placeholder="Phone Number"
                                                        />
                                                    @else
                                                        <input type="text" class="form-control" name="nok_relationship" placeholder="{{$user->nok?ucfirst($user->nok->phone):''}}" disabled>
                                                        <input type="hidden" name="nok_relationship" value="{{$user->nok?$user->nok->phone:''}}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group form-material" data-plugin="formMaterial">
                                                    <label class="form-control-label" for="inputText">Address of Next of Kin</label>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <textarea class="form-control" id="nok_address"  name="nok_address" rows="3">{{$user->nok()->count()>0?$user->nok->address:''}}</textarea>
                                                    @else
                                                        <textarea class="form-control"   name="nok_address" rows="3" disabled placeholder="{{$user->nok()->count()>0?$user->nok->address:''}}"></textarea>

                                                        <input type="hidden" name="nok_address" value="{{$user->nok?$user->nok->address:''}}">
                                                    @endif
                                                </div>
                                            </div>



                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-lg">Save</button>
                                    </form>

                                </div>











                                <div class="tab-pane animation-slide-left" id="academics" role="tabpanel">
                                    <br>
                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                        <button class="btn btn-primary " data-target="#addQualificationModal" data-toggle="modal">Add Qualification</button>
                                    @endif
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Title:</th>
                                            <th >Qualification:</th>
                                            <th >Year:</th>
                                            <th >Institution:</th>
                                            <th >CGPA/ Grad / Score:</th>
                                            <th >Discipline:</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->educationHistories as $history)
                                            <tr>
                                                <td>{{$history->title}}</td>
                                                @if($history->qualification_id>0)
                                                    <td>{{$history->qualification->name}}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>{{$history->year}}</td>
                                                <td>{{$history->institution}}</td>
                                                <td>{{$history->grade}}</td>
                                                <td>{{$history->course}}</td>
                                                <td>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
                                                                <a class="dropdown-item" id="{{$history->id}}" onclick="prepareEditAHData(this.id)"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit Qualification</a>
                                                                <a class="dropdown-item" id="{{$history->id}}" onclick="deleteAcademicHistory(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete Qualification</a>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane animation-slide-left" id="dependants" role="tabpanel">
                                    <br>
                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                        <button class="btn btn-primary " data-target="#addDependantModal" data-toggle="modal">Add Dependant</button>
                                    @endif
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Name:</th>
                                            <th >Date of Birth:</th>
                                            <th >Email:</th>
                                            <th >Phone Number:</th>
                                            <th >Relationship:</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->dependants as $dependant)
                                            <tr>
                                                <td>{{$dependant->name}}</td>
                                                <td>{{date("F j, Y", strtotime($dependant->dob))}}</td>
                                                <td>{{$dependant->email}}</td>
                                                <td>{{$dependant->phone}}</td>
                                                <td>{{ucfirst($dependant->relationship)}}</td>
                                                <td>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
                                                                <a class="dropdown-item" id="{{$dependant->id}}" onclick="prepareEditDData(this.id)"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit Dependant</a>
                                                                <a class="dropdown-item" id="{{$dependant->id}}" onclick="deleteDependant(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete Dependant</a>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane animation-slide-left" id="skills" role="tabpanel">
                                    <br>
                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                        <button class="btn btn-primary " data-target="#addSkillModal" data-toggle="modal">Add Skill</button>
                                    @endif
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Skill:</th>
                                            <th >Competency:</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->skills as $skill)
                                            <tr>
                                                <td>{{$skill->name}}</td>
                                                <td>{{ (!is_null($skill->pivot->competency))? $skill->pivot->competency->proficiency:'N/A' }}</td>
                                                <td>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="exampleIconDropdown1"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
                                                                <a class="dropdown-item" id="{{$skill->id}}" onclick="prepareEditSData(this.id)"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit Skill</a>
                                                                <a class="dropdown-item" id="{{$skill->id}}" onclick="deleteSkill(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete Skill</a>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>


                                @include('empmgt.partials.offline_training_history')

                                <div class="tab-pane animation-slide-left" id="experience" role="tabpanel">
                                    {{--                    PROMOTION HISTORY--}}
                                    <br>
                                    <legend style="color:black">Promotion History</legend><hr>
                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                        <button class="btn btn-primary " data-target="#changeGradeModal" data-toggle="modal">Change Grade</button>
                                    @endif
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="200" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Old Grade:</th>
                                            <th >New Grade:</th>
                                            <th >Approved By</th>
                                            <th >Approved On</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->promotionHistories as $phistory)
                                            <tr>

                                                <td>{{$phistory->oldgrade?$phistory->oldgrade->level:''}}</td>
                                                <td>{{$phistory->grade?$phistory->grade->level:''}}</td>
                                                <td>{{$phistory->approver?$phistory->approver->name:''}}</td>
                                                <td>{{date("F j, Y", strtotime($phistory->approved_on))}}</td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                     {{--                    Posting HISTORY --}}
                                    <br>
                                    <legend style="color:black">Posting History</legend><hr>
                                    
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="200" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Location:</th>
                                            <th >Posting Type:</th>
                                            <th >Effective Date</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->postings as $posting)
                                        @if($posting->approval_status==1)
                                            <tr>

                                                <td>{{$posting->location}}</td>
                                                <td>{{$posting->posting_type->name}}</td>
                                                <td>{{$posting->effective_date?date("F j, Y", strtotime($posting->effective_date)):''}}</td>
                                                
                                            </tr>
                                            @endif
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                    {{--                    JOB HISTORY --}}
                                    <br>
                                    <legend style="color:black">Job History</legend><hr>
                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                        <button class="btn btn-primary " data-target="#assignJobRoleModal" data-toggle="modal">Assign New Job</button>
                                    @endif
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="200" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Job Role:</th>
                                            <th >Department:</th>
                                            <th >Started on</th>
                                            <th >Ended</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->jobs as $job)
                                            <tr>

                                                <td>{{$job->title}}</td>
                                                <td>{{$job->department->name}}</td>
                                                <td>{{$job->pivot->started?date("F j, Y", strtotime($job->pivot->started)):''}}</td>
                                                <td>{{$job->pivot->ended?date("F j, Y", strtotime($job->pivot->ended)):''}}</td>
                                                <td>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="exampleIconDropdown1"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">

                                                                <a class="dropdown-item" id="{{$job->id}}" onclick="deleteJob(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Remove Job</a>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>

                                    {{--                  WORK EXPERIENCE  --}}
                                    <br>
                                    <legend style="color:black">Work Experience</legend><hr>

                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                        <button class="btn btn-primary " data-target="#addWorkExperienceModal" data-toggle="modal">Add Employment History</button>
                                    @endif
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="200" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Organization:</th>
                                            <th >Position:</th>
                                            <th >Start Date:</th>
                                            <th >End Date:</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->employmentHistories as $ehistory)
                                            <tr>
                                                <td>{{$ehistory->organization}}</td>
                                                <td>{{$ehistory->position}}</td>
                                                <td>{{date("F j, Y", strtotime($ehistory->start_date))}}</td>
                                                <td>{{date("F j, Y", strtotime($ehistory->end_date))}}</td>
                                                <td>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
                                                                <a class="dropdown-item" id="{{$ehistory->id}}" onclick="prepareEditWEData(this.id)"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit Employment History</a>
                                                                <a class="dropdown-item" id="{{$ehistory->id}}" onclick="deleteWorkExperience(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete Employment History</a>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>



                                </div>


                                <div class="tab-pane animation-slide-left" id="direct_reports" role="tabpanel">
                                    {{--                    DIRECT REPORT --}}
                                    <br>
                                    <legend style="color:black">Direct Report(s)</legend><hr>
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Name:</th>
                                            <th >Email:</th>
                                            <th >Type:</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->employees as $employee)
                                            <tr>
                                                <td>{{$employee->name}}</td>
                                                <td>{{$employee->email}}</td>
                                                <td class=" {{$employee->line_manager_id==$user->id?"text-primary":""}}">{{$employee->line_manager_id==$user->id?"Primary Manager":"Secondary Manager"}}</td>
                                                <td>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="exampleIconDropdown1"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
                                                                @if($employee->line_manager_id!=$user->id)
                                                                    <a class="dropdown-item" id="{{$employee->id}}" onclick="makePrimaryManager({{$user->id}},this.id)"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Make Primary Line Manager</a>
                                                                @endif
                                                                <a class="dropdown-item" id="{{$employee->id}}" onclick="removeManager({{$user->id}},this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Remove Direct report</a>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                    {{--MANAGERS --}}
                                    <br>
                                    <legend style="color:black">Manager(s)</legend><hr>
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Name:</th>
                                            <th >Email:</th>
                                            <th >Type:</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->managers as $manager)
                                            <tr>
                                                <td>{{$manager->name}}</td>
                                                <td>{{$manager->email}}</td>
                                                <td class="{{$manager->id==$user->line_manager_id?"text-primary":""}}">{{$manager->id==$user->line_manager_id?"Primary Manager":"Secondary Manager"}}</td>
                                                <td>
                                                    @if (Auth::user()->role->permissions->contains('constant', 'manage_user'))
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="exampleIconDropdown1"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
                                                                @if($manager->id!=$user->line_manager_id)
                                                                    <a class="dropdown-item" id="{{$manager->id}}" onclick="makePrimaryManager(this.id,{{$user->id}})"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Make Primary Line Manager</a>
                                                                @endif
                                                                @if (Auth::user()->role->permissions->contains('constant', 'edit_user_advanced'))
                                                                    <a class="dropdown-item" id="{{$manager->id}}" onclick="removeManager(this.id,{{$user->id}})"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Remove Manager</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane animation-slide-left" id="user_groups" role="tabpanel">
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th >Name:</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($user->user_groups as $group)
                                            <tr>
                                                <td>{{$group->name}}</td>
                                                <td></td>
                                            </tr>
                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>


                                <div class="tab-pane animation-slide-left"  id="query_history" role="tabpanel">
                                    <table id="exampleTablePagination" data-toggle="table"
                                           data-query-params="queryParams" data-mobile-responsive="true"
                                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Category of Offence</th>
                                            <th>Employee Name</th>
                                            <th>Status</th>
                                            <th>Query Excerpt</th>
                                            <th>Action Taken</th>
                                            <th>Date Issued</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($queries->where('queried_user_id',$user->id) as $query)
                                            <tr>
                                                <td id="query_title{{$query->id}}">{{$query->querytype->title}}</td>
                                                <td>{{$query->querieduser->name}}</td>
                                                <td><label class="tag tag-{{$query->status_color}}" id="status{{$query->id}}">{{$query->status}}<span style="visibility: hidden">..</span> </label></td>
                                                <td>
                                                    <input type="hidden" value="{{$query->content}}" id="query_parent{{$query->id}}">
                                                    <input type="hidden" value="{{$query->query_type_id}}" id="query_type_id{{$query->id}}">
                                                    <input type="hidden" value="{{$query->createdby->user_image}}" id="query_user_image{{$query->id}}">
                                                    <input type="hidden" value="{{$query->created_by}}" id="created_by{{$query->id}}">
                                                    <input type="hidden" value="{{$query->queried_user_id}}" id="queried_user_id{{$query->id}}">
                                                    <input type="hidden" value="{{$query->status}}" id="thread_status{{$query->id}}">
                                                    {{substr($query->content,0,200)}}...  </td>
                                                <td>
                                                    <b>{{strtoupper($query->action_taken)}}</b>
                                                </td>
                                                <td>
                                                    {{$query->created_at->diffForHumans()}}
                                                </td>
                                                <td>
                                                    <a target="_blank" class="btn btn-sm btn-success" href="{{url('query')}}/allqueries?query_id={{$query->id}}" >View More</a>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>

                                @include('empmgt.medical_history')
                            </div>

                        </div>
                    </div>
                    <!-- End Panel -->


                </div>

            </div>

        </div>
    </div>
    @include('empmgt.modals.adddependant')
    @include('empmgt.modals.addqualification')
    @include('empmgt.modals.addskill')
    @include('empmgt.modals.addworkexperience')
    @include('empmgt.modals.editdependant')
    @include('empmgt.modals.editqualification')
    @include('empmgt.modals.editskill')
    @include('empmgt.modals.editworkexperience')
    @include('empmgt.modals.changeGrade')
    @include('empmgt.modals.assignjobrole')
    @if($user->id==Auth::user()->id)
        @include('empmgt.modals.changepassword')
    @endif
    @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
        @include('empmgt.modals.addseparation')
        @include('empmgt.modals.addsuspension')
    @endif
@endsection
@section('scripts')
    <script src="{{asset('global/vendor/select2/select2.min.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
    <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{asset("js/countries.js")}}"></script>
    {{-- <script language="javascript">
             populateCountries("country", "state");
         </script> --}}
    <script type="text/javascript">


        $(document).ready(function() {
            //date picker initialization
            $('.datepicker').datepicker({
               format: 'yyyy-mm-dd',
               autoclose: true,
               closeOnDateSelect: true
           });
            $('.selector').select2();
            //function for picture change
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function(event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function(){
                readURL(this);
            });


            $(document).on('submit', '#emp-data', function(event) {
                event.preventDefault();
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                // console.log(formdata);
                // return;
                //var formAction = form.attr('action');
                $.ajax({
                    url         : '{{url('users')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){
                        toastr["success"]("Changes saved successfully",'Success');
                    },
                    error:function(data, textStatus, jqXHR){

                        jQuery.each( data['responseJSON'], function( i, val ) {

                            jQuery.each( val, function( i, valchild ) {

                                toastr["error"](valchild[0]);

                            });

                        });
                        console.log(textStatus);
                        console.log(jqXHR);
                    }
                });

            });
            //submit form on button click
            $(document).on('click', '#datasave', function(e) {

                // document.getElementById("emp-data");
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = document.getElementById("emp-data");
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                    console.log(formdata);
                }
                // console.log(formdata);
                // return
                //var formAction = form.attr('action');
                $.ajax({
                    url         : '{{url('users')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){
                        toastr["success"]("Changes saved successfully",'Success');
                    },
                    error:function(data, textStatus, jqXHR){

                        jQuery.each( data['responseJSON'], function( i, val ) {

                            jQuery.each( val, function( i, valchild ) {

                                toastr["error"](valchild[0]);

                            });

                        });
                        console.log(data);
                        console.log(textStatus);
                        console.log(jqXHR);
                    }
                });

            });

        });

        $(function() {
            $(document).on('submit','#addDependantForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){
                        console.log(data);
                        // toastr.success("Changes saved successfully",'Success');
                        // $('#addDependantModal').modal('toggle');
                        // location.reload();

                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr.error(valchild[0]);
                            });
                        });
                    }
                });

            });
        });
        $(function() {



            $(document).on('submit','#editDependantForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        toastr.success("Changes saved successfully",'Success');
                        $('#editDependantModal').modal('toggle');
                        location.reload();
                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr["error"](valchild[0]);
                            });
                        });
                    }
                });

            });
        });


        function prepareEditDData(dependant_id){
            $.get('{{ url('/userprofile/dependant') }}/',{ dependant_id: dependant_id },function(data){

                $('#editdname').val(data.name);
                $('#editddob').val(data.dob);
                $('#editdemail').val(data.email);
                $('#editdphone').val(data.phone);
                $('#editdrelationship').val(data.relationship);
                $('#dependant_id').val(data.id);
                $('#editDependantModal').modal();
            });
        }

        function deleteDependant(dependant_id){
            $.get('{{ url('/userprofile/delete_dependant') }}/',{ dependant_id: dependant_id },function(data){
                if (data=='success') {
                    toastr.success("Dependant deleted successfully",'Success');
                    location.reload();
                }else{
                    toastr.error("Error deleting Dependant",'Error');
                }

            });
        }

        $(function() {
            $(document).on('submit','#addSkillForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){


                        toastr.success("Changes saved successfully",'Success');
                        $('#addSkillModal').modal('toggle');
                        location.reload();

                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr.error(valchild[0]);
                            });
                        });
                    }
                });

            });
        });
        $(function() {
            $(document).on('submit','#editSkillForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        toastr.success("Changes saved successfully",'Success');
                        $('#editSkillModal').modal('toggle');
                        location.reload();
                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr["error"](valchild[0]);
                            });
                        });
                    }
                });

            });

            $('.skills').select2({
                placeholder: "Skill",
                multiple: false,
                id: function(bond){ return bond._id; },
                ajax: {
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    url: function (params) {
                        return '{{url('job_skill_search')}}';
                    }
                },
                tags: true

            });

        });


        function prepareEditSData(skill_id){
            $.get('{{ url('/userprofile/skill') }}/',{ skill_id: skill_id,user_id:{{$user->id}} },function(data){


                $('#editscompetency').val(data.pivot.competency_id);
                $('#skill_id').val(data.id);
                $("#editsskill").find('option')
                    .remove();
                $('#editSkillModal').modal();
                $("#editsskill").append($('<option>', {value:data.id, text:data.name,selected:'selected'}));
            });
        }

        function deleteSkill(skill_id){
            $.get('{{ url('/userprofile/delete_skill') }}/',{ skill_id: skill_id,user_id:{{$user->id}} },function(data){
                if (data=='success') {
                    toastr.success("Skill deleted successfully",'Success');
                    location.reload();
                }else{
                    toastr.error("Error Deleting Skill",'Error');
                }

            });
        }
        function makePrimaryManager(manager_id,user_id){
            toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
            $.get('{{ url('/userprofile/primary_manager') }}/',{ manager_id:manager_id,user_id:user_id },function(data){
                if (data=='success') {
                    toastr.success("Success",'Success');
                    location.reload();
                }else{
                    toastr.error("Error Encountered",'Error');
                }

            });
        }
        function removeManager(manager_id,user_id){
            toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
            $.get('{{ url('/userprofile/remove_manager') }}/',{ manager_id: manager_id,user_id:user_id },function(data){
                if (data=='success') {
                    toastr.success("Manager removed successfully",'Success');
                    location.reload();
                }else{
                    toastr.error("Error Removing Manager",'Error');
                }

            });
        }
        function deleteJob(job_id){
            toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
            $.get('{{ url('/userprofile/delete_job_history') }}/',{ job_id: job_id,user_id:{{$user->id}} },function(data){
                if (data=='success') {
                    toastr.success("Job History deleted successfully",'Success');
                    location.reload();
                }else{
                    toastr.error("Error Deleting Job History",'Error');
                }

            });
        }

        $(function() {
            $(document).on('submit','#addQualificationForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        toastr.success("Changes saved successfully",'Success');
                        $('#addQualificationModal').modal('toggle');
                        location.reload();

                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr.error(valchild[0]);
                            });
                        });
                    }
                });

            });
        });
        $(function() {
            $(document).on('submit','#editQualificationForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        toastr.success("Changes saved successfully",'Success');
                        $('#editQualificationModal').modal('toggle');
                        location.reload();
                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr["error"](valchild[0]);
                            });
                        });
                    }
                });

            });
        });

        $(function() {
            $(document).on('submit','#assignJobRoleForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        toastr.success("Changes saved successfully",'Success');
                        $('#assignJobRoleModal').modal('toggle');
                        location.reload();
                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr["error"](valchild[0]);
                            });
                        });
                    }
                });

            });
        });


        function prepareEditAHData(emp_academic_id){
            $.get('{{ url('/userprofile/academic_history') }}/',{ academic_history_id: emp_academic_id },function(data){
                console.log(emp_academic_id);
                console.log(data);
                $('#editqqualification_id').val(data.qualification_id);
                $('#editqtitle').val(data.title);
                $('#editqinstitution').val(data.institution);
                $('#editqyear').val(data.year);
                $('#editqcourse').val(data.course);
                $('#editqgrade').val(data.grade);
                $('#academic_history_id').val(data.id);
                $('#editQualificationModal').modal();
            });
        }

        function deleteAcademicHistory(emp_academic_id){
            $.get('{{ url('/userprofile/delete_academic_history') }}/',{ academic_history_id: emp_academic_id },function(data){
                if (data=='success') {
                    toastr.success("Academic History deleted successfully",'Success');
                    location.reload();
                }else{
                    toastr.error("Error Deleting Academic History",'Success');
                }

            });
        }

        $(function() {
            $(document).on('submit','#addWorkExperienceForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        toastr.success("Changes saved successfully",'Success');
                        $('#addWorkExperienceModal').modal('toggle');
                        location.reload();

                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr.error(valchild[0]);
                            });
                        });
                    }
                });

            });
        });
        $(function() {
            $(document).on('submit','#editWorkExperienceForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        toastr.success("Changes saved successfully",'Success');
                        $('#editWorkExperienceModal').modal('toggle');
                        location.reload();
                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr["error"](valchild[0]);
                            });
                        });
                    }
                });

            });

            $(document).on('click','#changeGrade',function(event){
                event.preventDefault();
                grade=$("#grade_id").val();
                effective_date=$("#grade_effective_date").val();
                $.get('{{ url('/userprofile/changegrade') }}/',{ grade_id: grade,user_id:{{$user->id}},effective_date : effective_date },function(data){
                    toastr.success("Grade Changed Successfully",'Success');
                    $('#changeGradeModal').modal('toggle');
                    location.reload();
                });
            });
//make project payroll category visible
            @if ($user->payroll_type=='project')
            $('.p-cont').show();
            $('.p-elt').attr('required',true);
            @else
            $('.p-cont').hide();
            $('.p-elt').attr('required',false);
            @endif

            $('#payroll_type').on('change', function() {
                type= $(this).val();

                if(type=='project'){
                    $('.p-cont').show();
                    $('.p-elt').attr('required',true);
                }
                if(type!='project'){
                    $('.p-cont').hide();
                    $('.p-elt').attr('required',false);
                }


            });
        });


        function prepareEditWEData(work_experience_id){
            $.get('{{ url('/userprofile/work_experience') }}/',{ work_experience_id: work_experience_id },function(data){

                $('#editworganization').val(data.organization);
                $('#editwposition').val(data.position);
                $('#editwstart_date').val(data.start_date);
                $('#editwend_date').val(data.end_date);
                $('#work_experience_id').val(data.id);
                $('#editWorkExperienceModal').modal();
            });
        }

        function deleteWorkExperience(work_experience_id){
            $.get('{{ url('/userprofile/delete_work_experience') }}/',{ work_experience_id: work_experience_id },function(data){
                if (data=='success') {
                    toastr.success("Work Experience deleted successfully",'Success');
                    location.reload();
                }else{
                    toastr.error("Error Deleting Work Experience",'Success');
                }

            });
        }




        function departmentChange(department_id){
            event.preventDefault();
            $.get('{{ url('/users/department/jobroles') }}/'+department_id,function(data){


                if (data.jobs=='') {
                    $("#jobroles").empty();
                    $('#jobroles').append($('<option>', {value:0, text:'Please Create a Jobrole in Department'}));
                }else{
                    $("#jobroles").empty();
                    jQuery.each( data.jobroles, function( i, val ) {
                        $('#jobroles').append($('<option>', {value:val.id, text:val.title}));
                    });
                }

            });
        }
        function companyChange(company_id){
            event.preventDefault();
            $.get('{{ url('/users/company/departmentsandbranches') }}/'+company_id,function(data){


                if (data.branches=='') {
                    $("#branch_id").empty();
                    $('#branch_id').append($('<option>', {value:0, text:'Please Create a Branch'}));
                }else{
                    $("#branch_id").empty();
                    jQuery.each( data.branches, function( i, val ) {
                        $('#branch_id').append($('<option>', {value:val.id, text:val.name}));
                    });
                }

            });
        }
        //   function changeLgas(state_id){
        //     $.get('{{ url('/userprofile/lgas') }}/',{ state_id: state_id },function(data){
        //     $('#lga').html();
        //   jQuery.each( data, function( i, val ) {

        //      $("#lga").append($('<option>', {value:val.id, text:val.name}));
        //      // console.log(val.name);
        //             });
        // });
        //   }
        var country=$('#country').val();
        var state=$('#state').val();
        $('#country').select2({
            ajax: {
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                url: function (params) {
                    return '{{url('location/country')}}';
                }
            }
        });
        $('#state').select2({
            ajax: {
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                url: function (country) {
                    return '{{url('location/state')}}/'+$('#country').val();
                }
            }
        });
        $('#lga').select2({
            ajax: {
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                url: function (state) {
                    return '{{url('location/lga')}}/'+$('#state').val();
                }
            },
            tags: true
        });
        $('#separation_type').select2({
            ajax: {
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                url: function () {
                    return '{{url('separation/separation_types')}}/';
                }
            },
            tags: true
        });
        $('#suspension_type').select2({
            ajax: {
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                url: function () {
                    return '{{url('separation/suspension_types')}}/';
                }
            },
            tags: true
        });
        @if($user->id==Auth::user()->id)
        $(function() {
            $(document).on('submit','#changePasswordForm',function(event){
                event.preventDefault();
                toastr.info('Processing ...','Info',{timeOut: 0,closeButton: true,extendedTimeOut:0 });
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('userprofile.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        if(data=='success'){
                            toastr.success("Changes saved successfully",'Success');
                            $('#changePasswordModal').modal('toggle');
                            location.reload();
                        }
                        if(data=='failed'){
                            toastr.error("You entered the wrong password",'Wrong Current Password');
                        }


                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr.error(valchild[0]);
                            });
                        });
                    }
                });

            });

        });
        @endif

        @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
        $(function() {
            $(document).on('submit','#addSeparationForm',function(event){
                event.preventDefault();
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('separation.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        if(data=='success'){
                            toastr.success("User has been designated as separated successfully",'Success');
                            $('#addSeparationModal').modal('toggle');
                            location.reload();
                        }
                        if(data=='failed'){
                            toastr.error("You have no set the HireDate",'Wrong Hire date');
                        }


                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr.error(valchild[0]);
                            });
                        });
                    }
                });

            });

        });
        @endif
        @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
        $(function() {
            $(document).on('submit','#addSuspensionForm',function(event){
                event.preventDefault();
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url         : '{{route('separation.store')}}',
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){

                        if(data=='success'){
                            toastr.success("User has been suspended successfully",'Success');
                            $('#addSuspensionModal').modal('toggle');
                            location.reload();
                        }
                        if(data=='failed'){
                            toastr.error("User has not been suspended",'Existing Suspension');
                        }


                    },
                    error:function(data, textStatus, jqXHR){
                        jQuery.each( data['responseJSON'], function( i, val ) {
                            jQuery.each( val, function( i, valchild ) {
                                toastr.error(valchild[0]);
                            });
                        });
                    }
                });

            });

        });
        @endif
        function cadreChange(cadre_id){
            event.preventDefault();
            $.get('{{ url('/users/cadre/ranks') }}/'+cadre_id,function(data){


                if (data.ranks=='') {
                    $("#ranks").empty();
                    $('#ranks').append($('<option>', {value:0, text:'Please Create a Rank in Cadre'}));
                }else{
                    $("#ranks").empty();
                    $('#ranks').append($('<option>', {value:0, text:'Please Select a Rank'}));
                    jQuery.each( data.ranks, function( i, val ) {
                        $('#ranks').append($('<option>', {value:val.id, text:val.name}));
                    });
                }

            });
        }
        function zoneChange(zone_id){
            event.preventDefault();
            $.get('{{ url('/users/zone/field_offices') }}/'+zone_id,function(data){


                if (data.field_offices=='') {
                    $("#field_offices").empty();
                    $('#field_offices').append($('<option>', {value:0, text:'Please Create a Field Office in Zone'}));
                }else{
                    $("#field_offices").empty();
                    $('#field_offices').append($('<option>', {value:0, text:'Please Select a Field Office'}));
                    jQuery.each( data.field_offices, function( i, val ) {
                        $('#field_offices').append($('<option>', {value:val.id, text:val.name}));
                    });
                }

            });
        }
        function departmentDivisionChange(department_id){
            event.preventDefault();
            $.get('{{ url('/users/department/divisions') }}/'+department_id,function(data){


                if (data.divisions=='') {
                    $("#divisions").empty();
                    $('#divisions').append($('<option>', {value:0, text:'Please Create a division in department'}));
                }else{
                    $("#divisions").empty();
                    $('#divisions').append($('<option>', {value:0, text:'Please Select a Division'}));
                    jQuery.each( data.divisions, function( i, val ) {
                        $('#divisions').append($('<option>', {value:val.id, text:val.name}));
                    });
                }

            });
        }
    </script>

    @include('empmgt.medical_history_script')


    @include('training_new.js_plugin.rating_plugin')
    @include('training_new.js_framework.binder_v2')

@endsection
