<script type="text/javascript">
    function previewEvaluation2(emp_id,sel){
        $.get('{{url('aper/get_evaluation_assessments_preview')}}',{
                employee:emp_id,
                mp:'{{$mp->id}}'
            },
            function(data,status){
                $('#preview-content').html(data);
                // $( "#preview" ).modal();
                $('#empname').html(sel.options[sel.selectedIndex].text);
            });
    }
</script>
@php

     $total=0;
     $obtainable=0;
@endphp
<div class="col-md-9">
    <select class="form-control "  onchange="previewEvaluation2(this.value,this)" >
        <option>--Select Employee--</option>

        @forelse($reports as $report)
            <option value="{{$report->id}}"  {{$employee->id==$report->id?'Selected':''}}>{{$report->name}}</option>
        @empty
            <option value="0" >No Employee</option>
        @endforelse
    </select>
</div>
<div class="col-md-3">
    <div class="btn-group" role="group" style="color: #fff;padding-right: 5px;margin-top: -5px;">
        <button type="button" class="btn  btn-default dropdown-toggle" id="exampleGroupDrop2" data-toggle="dropdown" aria-expanded="false">
            Share <i class="icon wb-share text-white" aria-hidden="true"></i>
        </button>
        <div style="color:#000;background:#fff ;z-index: 100;" class="dropdown-menu" aria-labelledby="exampleGroupDrop2" role="menu">

            <a style="color: #000;" class="dropdown-item" href="{{url('aper/export_assessment_excel?employee='.$employee->id.'&mp='.$mp->id)}}" role="menuitem">Export via Excel</a>
            <a style="color: #000;" class="dropdown-item" href="{{url('aper/export_assessment_pdf?employee='.$employee->id.'&mp='.$mp->id.'&view=report')}}" role="menuitem">Export via PDF</a>
            <a style="color: #000;" class="dropdown-item" href="{{url('aper/export_assessment_pdf?employee='.$employee->id.'&mp='.$mp->id.'&view=template')}}" role="menuitem">Export blank Template</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-xs-12">
        @forelse($aper_metrics as $metric)
            <h4>{{$metric->name}}</h4>
            <table class="table table-striped dis">
                <thead class="head">
                <tr style="background: #62a8eaab;color: #ffffff;">
                    <th style="text-align:left;padding-left: 10px;width: 45%;">Sub-Metric</th>
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
                         $obtainable+=5

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
    @empty
    @endforelse

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
    </div>
</div>
