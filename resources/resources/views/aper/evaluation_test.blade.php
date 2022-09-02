@extends('layouts.app')
@section('stylesheets')

    <link rel="stylesheet" href="{{asset('global/vendor/webui-popover/webui-popover.css')}}">

@endsection
@section('content')
    <style type="text/css">
        .head>tr> th{
            color: #fff;
        }
        .hover th,.hover td{
            text-align: center;
        }
        .dis th, .dis td{
            text-align: center;
        }
        .dis th:first-child,.dis td:first-child{
            text-align: left;
        }
    </style>
    @php
        $g_employee_id=request()->query('isemp');
        $employees=$directemps;
        $subjects=Helper::getSubjects();

    @endphp
    <script type="text/javascript">
        function addsubjectid(subject_id,subject_name){

            sub = document.getElementById("subject_id")
            sub.value=subject_id;
            head=document.getElementById("training_title")
            head.innerHTML='Add Sub-Metric to '+ subject_name;
        }
        function addid(module_id,module_name){
            document.getElementById("module_id").value=module_id;
            document.getElementById("editname").value=module_name;
        }

        function addmodule(){

            alertify.confirm('Are you sure you want to add the Sub Metric ?', function(){
                console.log($('#subject_id').val());
                $.post('{{route('post_performance_module_setting')}}',{

                    name:$('#name').val(),
                    subject_id:$('#subject_id').val(),
                    editable:1,
                    emp_id:{{$g_employee_id}},
                    _token:'{{csrf_token()}}'
                },function(data,status,xhr){
                    if(data=="Success"){
                        toastr.success('Operation Successfull');
                        setTimeout(function(){
                            window.location.reload();
                        },2000);
                        return;
                        //console.log(data);
                        //console.log(data);
                    }
                    toastr.error(data);
                    console.log(data);
                    console.log(status);



                });
            });

        }

        function editmodule(){

            alertify.confirm('Are you sure you want to save changes to this sub metric ?', function(){
                console.log($('#editname').val());
                $.post('{{route('post_performance_module_setting')}}',{
                    module_id:$('#module_id').val(),
                    name:$('#editname').val(),
                    _token:'{{csrf_token()}}'
                },function(data,status,xhr){
                    if(data=="Success"){
                        toastr.success('Operation Successfull');
                        setTimeout(function(){
                            window.location.reload();
                        },2000);
                        return;
                        //console.log(data);
                        //console.log(data);
                    }
                    toastr.error(data);
                    console.log(data);
                    console.log(status);



                });
            });

        }
        function deletemodule(module_id){

            alertify.confirm('Are you sure you want to delete this module ?', function(){


                $.get('{{route('delete_performance_module_setting')}}',{
                        module_id:module_id

                    },
                    function(data, status){
                        if(data=="Success"){
                            toastr.success('Module Deleted Successfully');
                            setTimeout(function(){
                                window.location.reload();
                            },2000);
                            return;

                        }
                        toastr.error(data);
                    });
            });

        }

        function previewEvaluation(emp_id){
            $.get('{{route('performance_evaluations')}}',{
                    isemp:emp_id
                },
                function(data,status){
                    $('#preview-content').html(data);
                    $( "#preview" ).modal();
                    console.log(data);
                });
        }
        function selectEmployee(emp_id){
            console.log(emp_id);

            $.get('{{route('performance_employee_add')}}',{
                    g_employee_id:emp_id
                },
                function(data, status){
                    if(data=="Success"){
                        toastr.success('Employee Selected');
                        setTimeout(function(){
                            window.location.reload();
                        },2000);
                        return;
                        //console.log(data);
                        //console.log(data);
                    }
                    toastr.error('Please Select an Employee');
                });

        }

        $(function (){

            @include('partials.select2empajax')
            @if (session()->has('save_msg'))
            toastr.success("{{session('save_msg')}}");
            @endif

            setInterval(function(){

                $('#time').html(new Date(new Date().getTime()).toLocaleTimeString());


            },1000);
        });
        @php
            $fiscal_year=Helper::getfiscalforp();
        @endphp
        @if (session(''))
            {{-- expr --}}
        @endif
    </script>
    <div class="page-header">
        <h1 class="page-title">Annual Performance Evaluation for {{Helper::getUser(request()->query('isemp'))->name}}  for  {{ session('FY')}} {{isset($status) ? '('.$status->resolve_action .' '.$status->created_at->diffForHumans().')' : ''}} </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/">Global Settings</a></li>
            <li class="breadcrumb-item active">You are Here</li>
        </ol>
        <div class="page-header-actions">
            <div class="row no-space w-250 hidden-sm-down">

                <div class="col-sm-6 col-xs-12">
                    <div class="counter">
                        <span class="counter-number font-weight-medium">{{date('Y-m-d')}}</span>

                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="counter">
                        <span class="counter-number font-weight-medium" id="time">08:32:56 am</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-bordered panel-primary nav-tabs-horizontal" data-plugin="tabs">
                <div class="panel-heading panel-heading-tab">
                    <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panelTab1"
                                                aria-controls="panelTab1" role="tab" aria-expanded="true">Performance Evalutaion</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panelTab2" aria-controls="panelTab2"
                                                role="tab">View Evaluation</a></li>
                        <li class="nav-item"><a class="nav-link"  id="{{$g_employee_id}}" onclick="previewEvaluation(this.id)" aria-controls="panelTab2" role="tab">Preview</a></li>

                    </ul>
                    <div class="panel-actions">
                        <select class="form-control "  onchange="window.location='{{ url('/')}}/{{ session('locale')}}/lm/performance_assessments?isemp='+ $(this).val();">
                            <option>--Select Employee--</option>

                            @forelse($employees as $employee)
                                <option value="{{$employee->id}}" {{$g_employee_id==$employee->id?'Selected':''}}>{{$employee->name}}</option>
                            @empty
                                <option value="0" >No Employee</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="panel-body p-t-20">
                    <div class="tab-content">
                        <a class="btn btn-primary" class="pop" id="examplePopWithTable" data-title="Keys For Aper" data-delay-show="300"  data-trigger="hover" href="javascript:void(0)">Keys For Aper</a>
                        <div id="examplePopoverTable" hidden>
                            <table class="table hover">
                                <thead>
                                <tr>
                                    <th>Score</th>
                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>5</td>

                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>4</td>

                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>3</td>

                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>2</td>

                                </tr>
                                <tr>
                                    <td>E</td>
                                    <td>1</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane active" id="panelTab1" role="tabpanel">

                        @php


                            if($g_employee_id>0):
                              if(count($subjects)>0):

                              foreach($subjects as $subject):
                                if(count($subject->performance_modules)>0):
                                foreach ($subject->performance_modules as $module):



                                  $verify_data  = array(  'user_id' => $g_employee_id ,
                                        'performance_module_id' => $module->id ,
                                        'fiscal_year' => $fiscal_year
                                        );
                                  $count=Helper::assessmentVerify($verify_data);

                                endforeach;
                              endif;
                              endforeach;
                            endif;
                            endif;
                        @endphp
                        <!-- Example Default Accordion -->
                            <div class="examle-wrap">



                                <form action="{{route('post_performance_assessment',['isemp'=>request()->query('isemp')])}}" method="post">
                                    <div class="example">
                                        <div class="panel-group" id="accordionDefault" aria-multiselectable="true"
                                             role="tablist">
                                            @forelse($subjects as $subject)


                                                <div class="panel">
                                                    <div class="panel-heading" id="heading_{{$subject->id}}" role="tab">
                                                        <a class="panel-title collapsed" data-toggle="collapse" href="#collapse_{{$subject->id}}"
                                                           data-parent="#accordionDefault" aria-expanded="false"
                                                           aria-controls="collapse_{{$subject->id}}">
                                                            {{$subject->name}} - Total score obtainable {{$subject->fillable==0?count($subject->performance_modules)*5:''}}marks
                                                        </a>
                                                    </div>
                                                    <div class="panel-collapse collapse" id="collapse_{{$subject->id}}" aria-labelledby="heading_{{$subject->id}}"
                                                         role="tabpanel">
                                                        <div class="panel-body">
                                                            <!-- Example Table From Data -->
                                                            <div class="col-lg-12 col-xs-12">
                                                                <!-- Example Bordered Table -->
                                                                <div class="example-wrap">
                                                                    @if($subject->fillable==1)
                                                                        <a role="button" href="#" class="btn btn-primary" data-toggle="modal" data-target="#addModuleModal" onclick="addsubjectid({{$subject->id}},'{{$subject->name}}');"> Add Submetric</a>
                                                                    @endif
                                                                    <div class="example table-responsive">
                                                                        <table class=" sub-metric table table-bordered table-striped dis">
                                                                            <thead class="head">
                                                                            <tr style="background: #62a8eaab;color: #ffffff;">
                                                                                <th>Sub-Metric</th>
                                                                                <th>A</th>
                                                                                <th>B</th>
                                                                                <th >C</th>
                                                                                <th >D</th>
                                                                                <th >E</th>
                                                                                @if($subject->fillable==1)
                                                                                    <th >Actions</th>
                                                                                @endif
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                            @php
                                                                                $subtotal=0;
                                                                            @endphp

                                                                            @forelse($subject->performance_modules as $pmodule)
                                                                                @if(($pmodule->editable==1 and $pmodule->emp_id==$g_employee_id)||$pmodule->editable==0)
                                                                                    @php
                                                                                        $verify_data  = array('user_id' => $g_employee_id ,
                                                                                           'performance_module_id' => $pmodule->id ,
                                                                                           'fiscal_year' => $fiscal_year
                                                                                           );
                                                                                         $assessment=Helper::getAssessment($verify_data);

                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>{{$pmodule->name}}</td>
                                                                                        @for ($i = 5; $i >0; $i--)
                                                                                            <td>
                                                                                                <input type="radio" data-plugin="iCheck" class="icheckbox-primary" name="module_{{$pmodule->id}}" value="{{$i}}" {{$i==$assessment->score?'checked':''}}>

                                                                                            </td>

                                                                                        @endfor
                                                                                        @if($subject->fillable==1)
                                                                                            <td><span><a class="my-btn   btn-sm text-primary" id="{{$pmodule->id}}" data-toggle="modal" data-target="#editModuleModal" onclick="addid(this.id,'{{$pmodule->name}}')"><i class="icon wb-pencil" aria-hidden="true"></i></a></span>
                                                                                                <span><a  class="my-btn text-danger   btn-sm" id="{{$pmodule->id}}" onclick="deletemodule(this.id)"><i class="icon wb-trash" aria-hidden="true"></i></a></span></td>
                                                                                        @endif
                                                                                    </tr>
                                                                                @endif
                                                                            @empty

                                                                            @endforelse
                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <!-- End Example Bordered Table -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            @empty
                                            @endforelse

                                        </div>
                                    </div>
                                    <div class="form-group">

                                        {{ csrf_field() }}
                                        <div class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="submit" class="btn btn-primary waves-effect" id="editmodule_btn" value="Save Evaluation" ></span>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- End Example Default Accordion -->

                        </div>
                        <div class="tab-pane" id="panelTab2" role="tabpanel">
                            <!-- Example Default Accordion -->
                            <div class="examle-wrap">


                                @php
                                    $total=0;
                                    $obtainable=0;
                                @endphp
                                <div class="example">
                                    <div class="panel-group" id="accordionDefault2" aria-multiselectable="true"
                                         role="tablist">
                                        @forelse($subjects as $subject)


                                            <div class="panel">
                                                <div class="panel-heading" id="heading2_{{$subject->id}}" role="tab">
                                                    <a class="panel-title collapsed" data-toggle="collapse" href="#collapse2_{{$subject->id}}"
                                                       data-parent="#accordionDefault2" aria-expanded="false"
                                                       aria-controls="collapse_{{$subject->id}}">
                                                        {{$subject->name}} - Total score obtainable {{count($subject->performance_modules)*5}}marks
                                                    </a>
                                                </div>
                                                <div class="panel-collapse collapse" id="collapse2_{{$subject->id}}" aria-labelledby="heading2_{{$subject->id}}"
                                                     role="tabpanel">
                                                    <div class="panel-body">
                                                        <!-- Example Table From Data -->
                                                        <div class="col-lg-12 col-xs-12">
                                                            <!-- Example Bordered Table -->
                                                            <div class="example-wrap">

                                                                <div class="example table-responsive">
                                                                    <table class=" sub-metric table table-bordered table-striped dis">
                                                                        <thead class="head">
                                                                        <tr style="background: #62a8eaab;color: #ffffff;">
                                                                            <th>Sub-Metric</th>
                                                                            <th>A</th>
                                                                            <th>B</th>
                                                                            <th >C</th>
                                                                            <th >D</th>
                                                                            <th >E</th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                        @php
                                                                            $subtotal=0;
                                                                        @endphp
                                                                        @forelse($subject->performance_modules as $pmodule)
                                                                            @php
                                                                                $verify_data  = array(  'user_id' => $g_employee_id ,
                                                                                   'performance_module_id' => $pmodule->id ,
                                                                                   'fiscal_year' => $fiscal_year
                                                                                   );
                                                                                 $assessment=Helper::getAssessment($verify_data);
                                                                                  $subtotal+=$assessment->score;
                                                                                  $obtainable+=5
                                                                            @endphp
                                                                            <tr>
                                                                                <td>{{$pmodule->name}}</td>
                                                                                @for ($i = 5; $i >0; $i--)
                                                                                    <td>
                                                                                        <i class="icon {{$i==$assessment->score?'wb-check-circle':''}} text-success"></i>

                                                                                    </td>
                                                                                @endfor
                                                                            </tr>
                                                                        @empty

                                                                        @endforelse
                                                                        </tbody>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <th colspan="6"> Sub Total:{{$subtotal}}</th>
                                                                            @php
                                                                                $total+=$subtotal;
                                                                            @endphp
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- End Example Bordered Table -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        @empty
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                            <!-- End Example Default Accordion -->
                            <ul class="list-group list-group-gap">
                                <li class="list-group-item bg-blue-grey-100">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i> Obtainable:{{$obtainable}}
                                </li>
                                <li class="list-group-item bg-blue-grey-100">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i> Obtained:{{$total}}
                                </li>
                                <li class="list-group-item bg-blue-grey-100">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i> Overall Assessment:{{round(($total/$obtainable)*20,2)}}
                                </li>

                            </ul>
                            @if(isset($status) && $total >0)
                                <ul class="list-group list-group-gap">
                                    <li class="list-group-item bg-blue-grey-100">

                                        Status: {{$status->resolve_action}}
                                    </li>

                                    <li class="list-group-item bg-blue-grey-100">

                                        Message: {{$status->comment}}
                                    </li>

                                </ul>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade modal-primary example-modal-lg" aria-hidden="true" id="preview" aria-labelledby="exampleOptionalLarge"
         role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                    <h4 class="modal-title" id="exampleOptionalLarge">Annual Performance Evaluation for <span id="empname">{{Helper::getUser(request()->query('isemp'))->name}}<span></h4>
                </div>
                <div class="modal-body " id="preview-content">

                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--- Add submetric modal start -->
    <div class="modal fade in modal-3d-flip-horizontal modal-primary" id="addModuleModal" aria-hidden="true" aria-labelledby="addModuleModal"
         role="dialog" tabindex="-1">

        <div class="modal-dialog ">
            <form class="form-horizontal" id="add_module_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title" id="training_title">Add Sub-Metric</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row row-lg col-xs-12">
                            <div class="col-xs-12">


                                <div class="form-group">
                                    <h4 class="example-title">Sub-Metric Name</h4>

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Sub-Metric Name" value="" required>
                                </div>
                                <div id="training_name_err"></div>




                            </div>
                            <div class="clearfix hidden-sm-down hidden-lg-up"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xs-12">
                            <!-- Example Textarea -->
                            <div class="form-group">
                                <input type="hidden" name="subject_id" id="subject_id">
                                {{ csrf_field() }}
                                <div class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="button" class="btn btn-primary waves-effect" id="sugtraining_btn" value="Save" onclick="addmodule()"></span>
                                    <span class="no-left-padding"><input type="button" class="btn btn-default waves-effect" value="Cancel"  data-dismiss="modal"></span></div>
                            </div>
                            <!-- End Example Textarea -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add sub metric modal end -->
    <!--- Edit Module modal start -->
    <div class="modal fade in modal-3d-flip-horizontal modal-primary" id="editModuleModal" aria-hidden="true" aria-labelledby="editModuleModal"
         role="dialog" tabindex="-1">

        <div class="modal-dialog ">
            <form class="form-horizontal" id="edit_module_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title" id="training_title">Edit Sub-Metric</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row row-lg col-xs-12">
                            <div class="col-xs-12">


                                <div class="form-group">
                                    <h4 class="example-title">Sub-Metric Name</h4>

                                    <input type="text" class="form-control" id="editname" name="editname" placeholder="Sub-Metric Name" value="" required>
                                </div>
                                <div id="training_name_err"></div>




                            </div>
                            <div class="clearfix hidden-sm-down hidden-lg-up"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xs-12">
                            <!-- Example Textarea -->
                            <div class="form-group">
                                <input type="hidden" name="module_id" id="module_id" value="0">
                                {{ csrf_field() }}
                                <div class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="button" class="btn btn-primary waves-effect" id="editmodule_btn" value="Save" onclick="editmodule()"></span>
                                    <span class="no-left-padding"><input type="button" class="btn btn-default waves-effect" value="Cancel"  data-dismiss="modal"></span></div>
                            </div>
                            <!-- End Example Textarea -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add module modal end -->

@endsection
@section('scripts')
    <script src="{{asset('global/vendor/webui-popover/jquery.webui-popover.min.js')}}"></script>
    <script src="{{asset('global/js/Plugin/webui-popover.js')}}"></script>
    <script src="{{asset('assets/examples/js/uikit/tooltip-popover.js')}}"></script>
    <script type="text/javascript">
        $(function (){
            $('#pop').webuiPopover({url:'#popContent'});
        });
    </script>

@endsection
