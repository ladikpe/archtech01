@extends('layouts.master')
@section('stylesheets')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
      <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
      <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('global/vendor/webui-popover/webui-popover.css')}}">
  <style media="screen">
    .form-cont{
      border: 1px solid #cccccc;
      padding: 10px;
      border-radius: 5px;
    }
    #stgcont {
      list-style: none;
    }
    #stgcont li{
      margin-bottom: 10px;
    }
  </style>

@endsection
@section('content')
<div class="page ">
    <div class="page-header">
      <h1 class="page-title">APER Evaluation</h1>
      <div class="page-header-actions">
    <div class="row no-space w-250 hidden-sm-down">

      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium">{{date("M j, Y")}}</span>

        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium" id="time">{{date('h:i s a')}}</span>

        </div>
      </div>
    </div>
  </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-bordered panel-info nav-tabs-horizontal" data-plugin="tabs">
                    <div class="panel-heading panel-heading-tab">
                        <div class="nav-tabs-horizontal" data-plugin="tabs">
                        <ul class="nav nav-tabs nav-tabs-solid" role="tablist" style="background-color: #03a9f4">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panelTab1"
                                                    aria-controls="panelTab1" role="tab" aria-expanded="true">Performance Evalutaion</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panelTab2" aria-controls="panelTab2"
                                                    role="tab">View Evaluation</a></li>
                            <li class="nav-item"><a class="nav-link"  id="{{$employee->id}}" onclick="previewEvaluation(this.id)" aria-controls="panelTab2" role="tab">Preview</a></li>

                        </ul>
                        </div>
                        <div class="panel-actions">
                            <button class="btn btn-default" onclick="loadPerformanceDiscussion({{$evaluation->id}})">View Performance Discussions</button>
                            <select class="form-control "  onchange="window.location='{{ url('aper/get_evaluation')}}?mp={{$mp->id}}&employee='+ $(this).val();">
                                <option>--Select Employee--</option>

                                @forelse($reports as $report)
                                    <option value="{{$report->id}}" {{$employee->id==$report->id?'Selected':''}}>{{$report->name}}</option>
                                @empty
                                    <option value="0" >No Employee</option>
                                @endforelse
                            </select>
                        </div>

                    </div>
                    <div class="panel-body p-t-20">
                        <div class="tab-content">
                            <a class="btn btn-info" class="pop" id="examplePopWithTable" data-title="Keys For Aper" data-delay-show="300"  data-trigger="hover" href="javascript:void(0)">Keys For Aper</a>
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
                                <div class="examle-wrap">
                                    <form action="{{url('aper')}}" method="post">
                                        <div class="example">
                                            <div class="panel-group" id="accordionDefault" aria-multiselectable="true"
                                                 role="tablist">
                                                @forelse($aper_metrics as $metric)


                                                    <div class="panel panel-info">
                                                        <div class="panel-heading" id="heading_{{$metric->id}}" role="tab">
                                                            <a class="panel-title collapsed" data-toggle="collapse" href="#collapse_{{$metric->id}}"
                                                               data-parent="#accordionDefault" aria-expanded="false"
                                                               aria-controls="collapse_{{$metric->id}}">
                                                                {{$metric->name}} - Total score obtainable {{$metric->fillable==0?count($metric->sub_metrics)*5:''}}marks
                                                            </a>
                                                        </div>
                                                        <div class="panel-collapse collapse" id="collapse_{{$metric->id}}" aria-labelledby="heading_{{$metric->id}}"
                                                             role="tabpanel">
                                                            <div class="panel-body">
                                                                <!-- Example Table From Data -->
                                                                <div class="col-lg-12 col-xs-12">
                                                                    <!-- Example Bordered Table -->
                                                                    <div class="example-wrap">
                                                                        @if($metric->fillable==1)
                                                                            <a role="button" href="#" class="btn btn-info" data-toggle="modal" data-target="#addSubMetricModal" onclick="add_metric_id({{$metric->id}},'{{$metric->name}}');"> Add SubMetric</a>
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
                                                                                    @if($metric->fillable==1)
                                                                                        <th >Actions</th>
                                                                                    @endif
                                                                                </tr>
                                                                                </thead>

                                                                                <tbody>
                                                                                @php
                                                                                    $subtotal=0;
                                                                                @endphp

                                                                                @forelse($metric->sub_metrics as $sub_metric)
                                                                                    @if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0)
                                                                                        @php
                                                                                             $assessment=$evaluations[$metric->id][$sub_metric->id]['assessment_detail'];

                                                                                        @endphp
                                                                                        <tr>
                                                                                            <td>{{$sub_metric->name}}</td>
                                                                                            @for ($i = 5; $i >0; $i--)
                                                                                                <td>
                                                                                                    <input type="radio" data-plugin="iCheck" class="icheckbox-info" name="sub_metric_{{$sub_metric->id}}" value="{{$i}}" {{$i==$assessment->score?'checked':''}}>

                                                                                                </td>

                                                                                            @endfor
                                                                                            @if($metric->fillable==1)
                                                                                                <td><span><a class="btn-info text-white   btn-sm " id="{{$sub_metric->id}}" data-toggle="modal" data-target="#editSubMetricModal" onclick="add_sub_metric_id(this.id,'{{$sub_metric->name}}')"><i class="fa fa-edit text-white " aria-hidden="true"></i></a></span>
                                                                                                    <span><a  class="btn-danger text-white  btn-sm" id="{{$sub_metric->id}}" onclick="delete_sub_metric(this.id)"><i class="fa fa-trash text-white " aria-hidden="true"></i></a></span></td>
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
                                            <input type="hidden" name="assessmemt_id" id="sub_metric_id" value="{{$evaluation->id}}">
                                            <input type="hidden" name="type"  value="save_performance_assessment">
                                            {{ csrf_field() }}
                                            <div class="text-xs-left"><span class="no-left-padding" id="btn_div"><button type="submit" class="btn btn-info waves-effect" id="editmodule_btn" >Save Evaluation</button></span>
                                            </div>
                                        </div>
                                    </form>

                                </div>
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
                                            @forelse($aper_metrics as $metric)


                                                <div class="panel panel-info">
                                                    <div class="panel-heading" id="heading2_{{$metric->id}}" role="tab">
                                                        <a class="panel-title collapsed" data-toggle="collapse" href="#collapse2_{{$metric->id}}"
                                                           data-parent="#accordionDefault2" aria-expanded="false"
                                                           aria-controls="collapse_{{$metric->id}}">
                                                            {{$metric->name}} - Total score obtainable {{count($metric->sub_metrics)*5}} marks
                                                        </a>
                                                    </div>
                                                    <div class="panel-collapse collapse" id="collapse2_{{$metric->id}}" aria-labelledby="heading2_{{$metric->id}}"
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
                                                                            @forelse($metric->sub_metrics as $sub_metric)
                                                                                @if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0)
                                                                                    @php
                                                                                        $assessment=$evaluations[$metric->id][$sub_metric->id]['assessment_detail'];
                                                                                    $subtotal+=$assessment->score;

                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>{{$sub_metric->name}}</td>
                                                                                        @for ($i = 5; $i >0; $i--)
                                                                                            <td>
                                                                                                <i class="fa {{$i==$assessment->score?'fa-check-circle':''}} text-success"></i>

                                                                                            </td>

                                                                                        @endfor

                                                                                    </tr>
                                                                                @endif


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
                                        <i class="fa fa-check-circle" aria-hidden="true"></i> Obtainable:
                                    </li>
                                    <li class="list-group-item bg-blue-grey-100">
                                        <i class="fa fa-check-circle" aria-hidden="true"></i> Obtained:
                                    </li>
                                    <li class="list-group-item bg-blue-grey-100">
                                        <i class="fa fa-check-circle" aria-hidden="true"></i> Overall Assessment:
                                    </li>

                                </ul>

                            </div>
                    </div>
                </div>
            </div>


  </div>


</div>
        <!-- Modal -->
        <div class="modal fade modal-info example-modal-lg" aria-hidden="true" id="preview" aria-labelledby="exampleOptionalLarge"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                        <h4 class="modal-title" id="exampleOptionalLarge">Annual Performance Evaluation for <span id="empname">{{$employee->name}}<span></h4>
                    </div>
                    <div class="modal-body " id="preview-content">

                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <!--- Add submetric modal start -->
        <div class="modal fade in modal-3d-flip-horizontal modal-info" id="addSubMetricModal" aria-hidden="true" aria-labelledby="addSubMetricModal"
             role="dialog" tabindex="-1">

            <div class="modal-dialog ">
                <form class="form-horizontal" id="add_sub_metric_form" role="form" method="POST">
                    <div class="modal-content">
                        <div class="modal-header" >
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                            <h4 class="modal-title" id="add_sub_metric_title">Add Sub-Metric</h4>
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
                                    <input type="hidden" name="metric_id" id="metric_id">
                                    {{ csrf_field() }}
                                    <div class="text-xs-left"><span class="no-left-padding" id="btn_div"><button  type="button" class="btn btn-info waves-effect" id="sugtraining_btn" onclick="add_sub_metric()">Save</button> </span>
                                        <span class="no-left-padding"><button type="button" class="btn btn-default waves-effect"  data-dismiss="modal">Cancel</button> </span></div>
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
        <div class="modal fade in modal-3d-flip-horizontal modal-info" id="editSubMetricModal" aria-hidden="true" aria-labelledby="editSubMetricModal"
             role="dialog" tabindex="-1">

            <div class="modal-dialog ">
                <form class="form-horizontal" id="edit_sub_metric_form" role="form" method="POST">
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

                                        <input type="text" class="form-control" id="editsmname" name="name" placeholder="Sub-Metric Name" value="" required>
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
                                    <input type="hidden" name="sub_metric_id" id="sub_metric_id" value="0">
                                    {{ csrf_field() }}
                                    <div class="text-xs-left"><span class="no-left-padding" id="btn_div"><button  type="button" class="btn btn-info waves-effect" id="" onclick="edit_sub_metric()">Save</button> </span>
                                        <span class="no-left-padding"><button type="button" class="btn btn-default waves-effect"  data-dismiss="modal">Cancel</button> </span></div>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('global/vendor/select2/select2.min.js')}}"></script>
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('global/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('global/vendor/webui-popover/jquery.webui-popover.min.js')}}"></script>
        <script src="{{asset('global/js/Plugin/webui-popover.js')}}"></script>
        <script src="{{asset('assets/examples/js/uikit/tooltip-popover.js')}}"></script>
        <script type="text/javascript">
            $(function (){
                $('#pop').webuiPopover({url:'#popContent'});
            });
        </script>
            <script type="text/javascript">
                function add_metric_id(metric_id,metric_name){

                    sub = document.getElementById("metric_id")
                    sub.value=metric_id;
                    head=document.getElementById("add_sub_metric_title")
                    head.innerHTML='Add Sub-Metric to '+ metric_name;
                }
                function add_sub_metric_id(sub_metric_id,sub_metric_name){
                    document.getElementById("sub_metric_id").value=sub_metric_id;
                    document.getElementById("editsmname").value=sub_metric_name;
                }

                function add_sub_metric(){

                    alertify.confirm('Are you sure you want to add the Sub Metric ?', function(){
                        console.log($('#metric_id').val());
                        $.post('{{url('apersettings')}}',{

                            name:$('#name').val(),
                            metric_id:$('#metric_id').val(),
                            editable:1,
                            user_id:{{$employee->id}},
                            type:'save_aper_editable_sub_metric',
                            _token:'{{csrf_token()}}'
                        },function(data,status,xhr){
                            if(data=="success"){
                                toastr.success('Operation Successfull');
                                setTimeout(function(){
                                    window.location.reload();
                                },2000);
                                return;
                                //console.log(data);
                                //console.log(data);
                            }
                            // toastr.error(data);
                            // console.log(data);
                            // console.log(status);



                        });
                    });

                }

                function edit_sub_metric(){

                    alertify.confirm('Are you sure you want to save changes to this sub metric ?', function(){
                        console.log($('#editname').val());
                        $.post('{{url('apersettings')}}',{
                            sub_metric_id:$('#sub_metric_id').val(),
                            name:$('#editsmname').val(),
                            type:'save_aper_editable_sub_metric',
                            _token:'{{csrf_token()}}'
                        },function(data,status,xhr){
                            if(data=="success"){
                                toastr.success('Operation Successfull');
                                setTimeout(function(){
                                    window.location.reload();
                                },2000);
                                return;
                                //console.log(data);
                                //console.log(data);
                            }
                            // toastr.error(data);
                            // console.log(data);
                            // console.log(status);



                        });
                    });

                }
                function delete_sub_metric(asm_id){

                    alertify.confirm('Are you sure you want to delete this Sub Metric ?', function(){


                        $.get('{{url('apersettings/delete_aper_sub_metric')}}',{
                                asm_id:asm_id

                            },
                            function(data, status){
                                if(data=="Success"){
                                    toastr.success('Sub Metric Deleted Successfully');
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
                    $.get('{{url('/aper/get_evaluation_assessments_preview')}}',{
                            employee:emp_id,
                            mp:'{{$mp->id}}'
                        },
                        function(data,status){
                            $('#preview-content').html(data);
                            $( "#preview" ).modal();
                            console.log(data);
                        });
                }
                function selectEmployee(emp_id){
                    console.log(emp_id);

                    $.get('{{url('performance_employee_add')}}',{
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

            </script>
@endsection
