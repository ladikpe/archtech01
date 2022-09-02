<div class="site-menubar bg-yellow-a200 blue-grey-800">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    @if(Auth::user()->role->manages=='none')
                        <li class="site-menu-item ">
                            <a href="{{ route('home') }}" dropdown-tag="false">
                                <i class="site-menu-icon md-home" aria-hidden="true"></i>
                                <span class="site-menu-title">Home</span>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->role->manages=='all')
                        <li class="dropdown site-menu-item has-sub">
                            <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                                <i class="site-menu-icon fa fa-sitemap" aria-hidden="true"></i>
                                <span class="site-menu-title">Home</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="site-menu-scroll-wrap is-list">
                                    <div>
                                        <div>
                                            <ul class="site-menu-sub site-menu-normal-list">






                                                @include('training_new.navs.nav_include')



                                                @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{url('users')}}">
                                                            <span class="site-menu-title">Manage Employees</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{url('userprofile/change_approval')}}">
                                                            <span class="site-menu-title">Approve Employee Profile Change</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{url('aper/get_hr_evaluation')}}">
                                                            <span class="site-menu-title">Manage Employees Performance (APER)</span>
                                                        </a>
                                                    </li>
                                                     <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('aper/get_eligible_users_aper')}}">
                                                            <span class="site-menu-title">APER Eligibility Report</span>
                                                        </a>
                                                    </li>
                                                    
                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('leave/graph_report')}}">
                                                            <span class="site-menu-title">Leave Report</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('leave/leave_spillovers')}}">
                                                            <span class="site-menu-title">Leave Spillovers</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{ url('leave/comp_leave_plan_calendar') }}">
                                                            <span class="site-menu-title">Leave Plan Calendar</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href=" {{url('document_requests/index')}}">
                                                            <span class="site-menu-title">Document Requests</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href=" {{url('postings/index')}}">
                                                            <span class="site-menu-title">Postings</span>
                                                        </a>
                                                    </li>
                                                     <li class="site-menu-item ">
                                                        <a class="animsition-link" href=" {{url('retirement_list')}}">
                                                            <span class="site-menu-title">Retirement List</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href=" {{url('company_documents/index')}}">
                                                            <span class="site-menu-title">Company Documents</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href=" {{url('employee_reimbursements/index')}}">
                                                            <span class="site-menu-title">Expense Reimbursements</span>
                                                        </a>
                                                    </li>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'view_aper_report'))
                                                        <li class="site-menu-item">
                                                            <a class="animsition-link" href="{{url('aper')}}/get_hr_index">
                                                                <span class="site-menu-title">View Aper Report</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('separation')}}">
                                                            <span class="site-menu-title">Separations</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('separation/suspensions')}}">
                                                            <span class="site-menu-title">Suspensions</span>
                                                        </a>
                                                    </li>

                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('unions')}}">
                                                            <span class="site-menu-title">Worker Unions</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('sections')}}">
                                                            <span class="site-menu-title">Staff Sections</span>
                                                        </a>
                                                    </li>
                                                    @if(Auth::user()->role->permissions->contains('constant', 'issue_query'))
                                                        <li class="site-menu-item">
                                                            <a class="animsition-link" href="{{url('query')}}/allqueries">
                                                                <span class="site-menu-title">All User Queries </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if(Auth::user()->role->permissions->contains('constant', 'manage_user'))
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{url('groups')}}">
                                                            <span class="site-menu-title">Manage User Groups</span>
                                                        </a>
                                                    </li>

                                                @endif
                                                @if(Auth::user()->role->permissions->contains('constant', 'view_timesheet')||Auth::user()->role->permissions->contains('constant', 'export_timesheet'))
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{ url('timesheets') }}">
                                                            <span class="site-menu-title">TimeSheets</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if(isset(\App\Setting::where('name','uses_tams')->where('company_id',companyId())->first()->value) && \App\Setting::where('name','uses_tams')->where('company_id',companyId())->first()->value=='1')
                                                    @if(Auth::user()->role->permissions->contains('constant', 'view_attendance'))
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{route('daily.attendance.report')}}">
                                                                <span class="site-menu-title">View Attendance</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(Auth::user()->role->permissions->contains('constant', 'view_shift_schedule'))
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{ route('employeeShiftSchedules') }}">
                                                                <span class="site-menu-title">Shift Schedules</span>
                                                            </a>
                                                        </li>
                                                    @endif


                                                @endif


                                                @if (Auth::user()->role->permissions->contains('constant', 'manage_organogram'))
                                                    <li class="site-menu-item ">
                                                        <a href="{{url('organograms/settings')}}"  class="animsition-link">
                                                            <span class="site-menu-title">Organogram Setup</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->role->permissions->contains('constant', 'view_audit_report'))
                                                    <li class="site-menu-item ">
                                                        <a href="{{url('audits/index')}}" type="button"  class="animsition-link">
                                                            <span class="site-menu-title">View Audit Log</span>
                                                        </a>
                                                    </li>
                                                @endif


                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                    @endif

                    <li class="dropdown site-menu-item has-sub">
                        <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon fa fa-sitemap" aria-hidden="true"></i>
                            <span class="site-menu-title">Self Service</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="site-menu-scroll-wrap is-list">
                                <div>
                                    <div>
                                        <ul class="site-menu-sub site-menu-normal-list">


                                            @include('training_new.navs.nav_include_self_service_section')



                                            @if(isset(\App\Setting::where('name','uses_tams')->where('company_id',companyId())->first()->value) && \App\Setting::where('name','uses_tams')->where('company_id',companyId())->first()->value=='1')
                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{ route('shift_schedule.user.my') }}">
                                                        <span class="site-menu-title">My Shift Schedule</span>
                                                    </a>
                                                </li>
                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{ route('attendance.user.cal') }}">
                                                        <span class="site-menu-title">My Attendance</span>
                                                    </a>
                                                </li>
                                            @endif

                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{ url('leave/myrequests') }}">
                                                    <span class="site-menu-title">Leave Requests</span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{ url('leave/approvals') }}">
                                                    <span class="site-menu-title">Leave Approvals</span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{ url('leave/relieve_approvals') }}">
                                                    <span class="site-menu-title">Relieve Approvals</span>
                                                </a>
                                            </li>

                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href=" {{url('document_requests/approvals')}}">
                                                    <span class="site-menu-title">Document Requests Approvals </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href=" {{url('postings/approvals')}}">
                                                    <span class="site-menu-title">Posting Approvals </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href=" {{url('employee_reimbursements/approvals')}}">
                                                    <span class="site-menu-title">Expense Reimbursement Approvals </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href=" {{url('document_requests/my_document_requests')}}">
                                                    <span class="site-menu-title">My Document Requests </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href=" {{url('company_documents/my_company_documents')}}">
                                                    <span class="site-menu-title">My Company Documents </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href=" {{url('employee_reimbursements/my_expense_reimbursements')}}">
                                                    <span class="site-menu-title">My Expense Reimbursements </span>
                                                </a>
                                            </li>

                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{ url('bsc/my_evaluations') }}">
                                                    <span class="site-menu-title">Performance Evaluation</span>
                                                </a>
                                            </li>

                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href=" {{url('loan/my_loan_requests')}}">
                                                    <span class="site-menu-title">Loan Requests </span>
                                                </a>
                                            </li>

                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{ url('document/mydocument') }}">
                                                    <span class="site-menu-title">My Documents </span>
                                                </a>
                                            </li>

                                            {{--
                                            <li class="site-menu-item ">
                                              <a class="animsition-link" href="#">
                                                <span class="site-menu-title">My Expenses </span>
                                              </a>
                                            </li> --}}
                                            <li class="site-menu-item">
                                                <a class="animsition-link" href="{{url('query')}}/allqueries?queried_user_id={{request()->user()->id}}">
                                                    <span class="site-menu-title">My Queries </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{url('recruits/myjobs')}}">
                                                    <span class="site-menu-title">Job Openings </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{url('organogram')}}">
                                                    <span class="site-menu-title">Organogram</span>
                                                </a>
                                            </li>

                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{url('directory')}}">
                                                    <span class="site-menu-title">Employee Directory </span>
                                                </a>
                                            </li>
                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{url('polls')}}">
                                                    <span class="site-menu-title">Polls </span>
                                                </a>
                                            </li>

                                            <li class="site-menu-item ">
                                                <a class="animsition-link" href="{{url('aper')}}/my_evaluations">
                                                    <span class="site-menu-title">My APER Evaluation </span>
                                                </a>
                                            </li>
                                            @if(Auth::user()->role->permissions->contains('constant', 'book_visit'))
                                                <li class="site-menu-item ">
                                                    <a class="animsition-link"  href="{{route('visitor.dashboard')}}">
                                                        <span class="site-menu-title">Visitor - Dashboard </span>
                                                    </a>
                                                </li>
                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{route('visitor.book.visit')}}">
                                                        <span class="site-menu-title">Visitor - Book Visit</span>
                                                    </a>
                                                </li>
                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{route('visitor.my.visitors')}}">
                                                        <span class="site-menu-title">Visitor - Manage My Visitors</span>
                                                    </a>
                                                </li>
                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{route('visitor.visitor.history')}}">
                                                        <span class="site-menu-title">Visitor - Visit History</span>
                                                    </a>
                                                </li>
                                            @endif</ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    @if(Auth::user()->employees->count() > 0)
                        <li class="site-menu-item ">
                          <a href="{{ url('aper')}}" dropdown-tag="false">
                            <i class="site-menu-icon md-check" aria-hidden="true"></i>
                            <span class="site-menu-title">APER</span>
                          </a>
                        </li>
                        
                        @endif
                    @if(Auth::user()->role->permissions->contains('constant', 'edit_performance'))
                        <li class="dropdown site-menu-item has-sub">
                            <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                                <i class="site-menu-icon fa fa-area-chart" aria-hidden="true"></i>
                                <span class="site-menu-title">Evaluation</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="site-menu-scroll-wrap is-list">
                                    <div>
                                        <div>
                                            <ul class="site-menu-sub site-menu-normal-list">

                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{ url('aper')}}">
                                                        <span class="site-menu-title">APER</span>
                                                    </a>
                                                </li>


                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{ route('promotions.index')}}">
                                                        <span class="site-menu-title">Promotion Module</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="dropdown site-menu-item has-sub">
                            <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                                <i class="site-menu-icon fa fa-circle-o-notch" aria-hidden="true"></i>
                                <span class="site-menu-title">Review 360</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="site-menu-scroll-wrap is-list">
                                    <div>
                                        <div>
                                            <ul class="site-menu-sub site-menu-normal-list">
                                                @if(Auth::user()->role->permissions->contains('constant', 'upload_review_questions'))
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{ url('e360settings/template') }}">
                                                            <span class="site-menu-title">Review Questions</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(Auth::user()->role->permissions->contains('constant', 'view_review_report'))
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{ url('e360/report_index')}}">
                                                            <span class="site-menu-title">Employee Review Report</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="site-menu-item ">
                                                    <a class="animsition-link" href="{{ url('e360')}}">
                                                        <span class="site-menu-title">Employee 360 Review</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @if(Auth::user()->role->permissions->contains('constant', 'front_desk'))
                            <li class="dropdown site-menu-item has-sub">
                                <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                                    <i class="site-menu-icon fa fa-circle-o-notch" aria-hidden="true"></i>
                                    <span class="site-menu-title">Visitor Front Desk</span>
                                    <span class="site-menu-arrow"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="site-menu-scroll-wrap is-list">
                                        <div>
                                            <div>
                                                <ul class="site-menu-sub site-menu-normal-list">
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link"
                                                           href="{{ route('visitor.front.dashboard') }}">
                                                            <span class="site-menu-title">Dashboard</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link"
                                                           href="{{ route('visitor.front.book.visit') }}">
                                                            <span class="site-menu-title">Book Visit</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif            @endif
                    <li class="dropdown site-menu-item has-section has-sub">
                        <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon fa fa-ellipsis-h" aria-hidden="true"></i>
                            <span class="site-menu-title">More</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu site-menu-sub site-menu-section-wrap blocks-md-4" >
                            @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports')||Auth::user()->role->permissions->contains('constant', 'view_attendance_report')||Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                                <li class="site-menu-section site-menu-item has-sub">
                                    <header>
                                        <i class="site-menu-icon fa fa-users" aria-hidden="true"></i>
                                        <span class="site-menu-title">Talent Management</span>
                                        <span class="site-menu-arrow"></span>
                                    </header>
                                    <div class="site-menu-scroll-wrap is-section">
                                        <div>
                                            <div>
                                                <ul class="site-menu-sub site-menu-section-list">
                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('jobs_departments')}}">
                                                            <span class="site-menu-title">Jobs</span>
                                                        </a>
                                                    </li>
                                                    <li class="site-menu-item">
                                                        <a class="animsition-link" href="{{url('recruits')}}">
                                                            <span class="site-menu-title">Recruit</span>
                                                        </a>
                                                    </li>
                                                    {{--                          <li class="site-menu-item has-sub">--}}
                                                    {{--                            <a href="javascript:void(0)">--}}
                                                    {{--                              <span class="site-menu-title">Training And Development</span>--}}
                                                    {{--                              <span class="site-menu-arrow"></span>--}}
                                                    {{--                            </a>--}}
                                                    {{--                            <ul class="site-menu-sub">--}}
                                                    {{--                              <li class="site-menu-item ">--}}
                                                    {{--                                <a class="animsition-link" href="{{url('newtraining')}}">--}}
                                                    {{--                                  <span class="site-menu-title">New Training</span>--}}
                                                    {{--                                </a>--}}
                                                    {{--                              </li>--}}
                                                    {{--                              <li class="site-menu-item ">--}}
                                                    {{--                                <a class="animsition-link" href="{{url('training')}}">--}}
                                                    {{--                                  <span class="site-menu-title">Recommended Training</span>--}}
                                                    {{--                                </a>--}}
                                                    {{--                              </li>--}}
                                                    {{--                              <li class="site-menu-item ">--}}
                                                    {{--                                <a class="animsition-link" href="{{url('mytraining')}}">--}}
                                                    {{--                                  <span class="site-menu-title">My Training</span>--}}
                                                    {{--                                </a>--}}
                                                    {{--                              </li>--}}
                                                    {{--                              <li class="site-menu-item ">--}}
                                                    {{--                              <a class="animsition-link" href="{{url('training/budget')}}">--}}
                                                    {{--                                <span class="site-menu-title">Training Budget</span>--}}
                                                    {{--                              </a>--}}
                                                    {{--                            </li>--}}
                                                    {{--                            </ul>--}}
                                                    {{--                          </li>--}}

                                                    {{-- <li class="site-menu-item">
                                                      <a class="animsition-link" href="uikit/dropdowns.html">
                                                        <span class="site-menu-title">Successiion Planning</span>
                                                      </a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports')||Auth::user()->role->permissions->contains('constant', 'view_attendance_report')||Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                                <li class="site-menu-section site-menu-item has-sub">
                                    <header>
                                        <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                                        <span class="site-menu-title">Executive Dashboard</span>
                                        <span class="site-menu-arrow"></span>
                                    </header>
                                    <div class="site-menu-scroll-wrap is-section">
                                        <div>
                                            <div>
                                                <ul class="site-menu-sub site-menu-section-list">

                                                    @if(Auth::user()->role->permissions->contains('constant', 'view_hr_reports'))
                                                        {{-- <li class="site-menu-item ">
                                                          <a class="animsition-link" href="{{url('bi-report')}}?page=demographics">
                                                            <span class="site-menu-title">Employee</span>
                                                          </a>
                                                        </li> 
                                                        
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{url('people_analytics_payroll')}}">
                                                                <span class="site-menu-title">Payroll</span>
                                                            </a>
                                                        </li>
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{url('people_analytics_performance')}}">
                                                                <span class="site-menu-title">Performance</span>
                                                            </a>
                                                        </li> 
                                                        
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{url('people_analytics_hr')}}">
                                                                <span class="site-menu-title">Demographics</span>
                                                            </a>
                                                        </li> --}}
                                                        
                                                        <li class="site-menu-item ">
                                                          <a class="animsition-link" href="{{url('bi-report')}}?page=demographics">
                                                            <span class="site-menu-title">Employee</span>
                                                          </a>
                                                        </li> 
                                                    @endif

                                                    @if(Auth::user()->role->permissions->contains('constant', 'view_leave_report'))
                                                        {{-- <li class="site-menu-item ">
                                                          <a class="animsition-link" href="{{url('bi-report')}}?page=payroll">
                                                            <span class="site-menu-title">Payroll</span>
                                                          </a>
                                                        </li> --}}
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        <!-- EMPLOYEE ENGAGEMENT -->
                            <li class="site-menu-section site-menu-item ">
                                <header>
                                    <i class="site-menu-icon  fa fa-trophy" aria-hidden="true"></i>
                                    <span class="site-menu-title" style="min-width: 200px !important;">EMPLOYEE ENGAGEMENT</span>
                                </header>

                                <div class="site-menu-scroll-wrap is-section">
                                    <div>
                                        <div>
                                            <ul class="site-menu-sub site-menu-section-list">

                                                @if(\Auth::user()->role->permissions->contains('constant', 'view_result'))
                                                    {{--      <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{url('awards')}}">
                                                              <span class="site-menu-title">AWARD Categories</span>
                                                            </a>
                                                          </li>

                                                          <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{url('attributes')}}">
                                                              <span class="site-menu-title">Categories Attributes</span>
                                                            </a>
                                                          </li>

                                                          <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{url('config')}}">
                                                              <span class="site-menu-title">Attributes Configuration</span>
                                                            </a>
                                                          </li>

                                                          --}}
                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{url('votereport')}}">
                                                            <span class="site-menu-title">AWARD Winners</span>
                                                        </a>
                                                    </li>

                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{url('merit-award')}}">
                                                            <span class="site-menu-title">Merit AWARD Winners</span>
                                                        </a>
                                                    </li>

                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{url('allusersvotereport')}}">
                                                            <span class="site-menu-title">All AWARD Analysis</span>
                                                        </a>
                                                    </li>

                                                @endif


                                                @foreach(App\AwardType::where('id', '<>', '3')->get() as $award)

                                                    <li class="site-menu-item ">
                                                        <a class="animsition-link" href="{{ url("startmenu?id={$award->id}&type=") }}@php echo base64_encode($award->name) @endphp ">
                                                            <span class="site-menu-title">{{ $award->name }}</span>
                                                            <!-- <span class="site-menu-arrow"></span> -->
                                                        </a>
                                                    </li>

                                                @endforeach



                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </li>









                            {{--  <li class="site-menu-section site-menu-item "> <a class="animsition-link" href="{{url('projects')}}">
                                 <i class="site-menu-icon  fa fa-list" aria-hidden="true"></i>
                                 <span class="site-menu-title">Project Management</span>

                             </a>
                         </li>--}}








                            {{-- <li class="site-menu-section site-menu-item ">


                               <a class="animsition-link" href="">
                                 <i class="site-menu-icon  fa fa-list" aria-hidden="true"></i>
                                 <span class="site-menu-title">E-Learning</span>
                               </a>

                             </li>--}}
                            @if(Auth::user()->role->permissions->contains('constant', 'view_attendance_report')||Auth::user()->role->permissions->contains('constant', 'view_attendance_report')))
                            @if(isset(\App\Setting::where('name','uses_tams')->where('company_id',companyId())->first()->value) && \App\Setting::where('name','uses_tams')->where('company_id',companyId())->first()->value=='1')
                                <li class="site-menu-section site-menu-item has-sub">
                                    <header>
                                        <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                                        <span class="site-menu-title">TAMS</span>
                                        <span class="site-menu-arrow"></span>
                                    </header>
                                    <div class="site-menu-scroll-wrap is-section">
                                        <div>
                                            <div>
                                                <ul class="site-menu-sub site-menu-section-list">
                                                    @if(Auth::user()->role->permissions->contains('constant', 'view_attendance_report'))
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{route('daily.attendance.report')}}">
                                                                <span class="site-menu-title">Daily Attendance Report</span>
                                                            </a>
                                                        </li>
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{route('monthly.attendance.report')}}">
                                                                <span class="site-menu-title">Monthly Attendance Report</span>
                                                            </a>
                                                        </li>
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{route('lateness.report')}}">
                                                                <span class="site-menu-title">Lateness Report</span>
                                                            </a>
                                                        </li>
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{route('employeeShiftSchedules')}}">
                                                                <span class="site-menu-title">Schedule Shifts</span>
                                                            </a>
                                                        </li>
                                                        <li class="site-menu-item ">
                                                            <a class="animsition-link" href="{{route('attendance.payroll')}}">
                                                                <span class="site-menu-title">Attendance Payroll</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @endif
                                {{--@if(Auth::user()->role->permissions->contains('constant', 'manage_import'))
                                    <li class="site-menu-section site-menu-item has-sub" style="z-index: 9999999999;">
                                         <header>
                                             <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                                             <span class="site-menu-title">Import Data</span>
                                             <span class="site-menu-arrow"></span>
                                         </header>
                                         <div class="site-menu-scroll-wrap is-section">
                                             <div>
                                                 <div>
                                                     <ul class="site-menu-sub site-menu-section-list">
   
                                                         <li class="site-menu-item ">
                                                             <a class="animsition-link" href="{{url('import')}}">
                                                                 <span class="site-menu-title">Import Data</span>
                                                             </a>
                                                         </li>
   
   
                             </ul>
                           </div>
                         </div>
                       </div>
                     </li> --}}

                      @if(Auth::user()->role->permissions->contains('constant', 'admin_dashboard'))
                           <li class="site-menu-section site-menu-item has-sub" style="z-index: 9999999999;">
                               <header>
                                   <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                                   <span class="site-menu-title">Admin Visitor Management</span>
                                   <span class="site-menu-arrow"></span>
                               </header>
                               <div class="site-menu-scroll-wrap is-section">
                                   <div>
                                       <div>
                                           <ul class="site-menu-sub site-menu-section-list">

                                               <li class="site-menu-item ">
                                                   <a class="animsition-link" href="{{route('visitor.admin.dashboard')}}">
                                                       <span class="site-menu-title">Dashboard</span>
                                                   </a>
                                               </li>

                                               <li class="site-menu-item ">
                                                   <a class="animsition-link" href="{{route('visitor.admin.visitor.history')}}">
                                                       <span class="site-menu-title">Visit History</span>
                                                   </a>
                                               </li>
                                               <li class="site-menu-item ">
                                                   <a class="animsition-link" href="{{route('visitor.admin.manage.history')}}">
                                                       <span class="site-menu-title">Visitors</span>
                                                   </a>
                                               </li>


                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                            @endif
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
