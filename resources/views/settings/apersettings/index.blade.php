<div class="page-header">
    <h1 class="page-title">{{__('All Settings')}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item ">{{__('Aper Settings')}}</li>
        <li class="breadcrumb-item active">{{__('You are Here')}}</li>
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
                    <span class="counter-number font-weight-medium" id="time"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-md-12 col-xs-12">


            <div class="panel panel-info panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">Metrics</h3>
                    <div class="panel-actions">
                        <button class="btn btn-info" data-toggle="modal" data-target="#addMetricModal">Add Metric</button>

                    </div>
                </div>
                <div class="panel-body">

                    <table id="exampleTablePagination" data-toggle="table"
                           data-query-params="queryParams" data-mobile-responsive="true"
                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                        <thead>
                        <tr>
                            <th >Name:</th>
                            <th>Fillable</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($metrics as $am)
                            <tr>
                                <td>@if($am->fillable==0)<a class="linker" href="{{url('apersettings/aper_sub_metrics')."?am_id=".$am->id}}">{{$am->name}}</a>@elseif($am->fillable==1){{$am->name}} @endif</td>
                                <td>{{$am->fillable==1?"Yes":"No"}}</td>
                                <td><a class="" title="edit" class="btn btn-icon btn-info" id="{{$am->id}}" onclick="prepareMetricEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a class="" title="delete" class="btn btn-icon btn-danger" id="{{$am->id}}" onclick="deletemetric(this.id);"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-info panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">Measurement Period</h3>
                    <div class="panel-actions">
                        <button class="btn btn-info" data-toggle="modal" data-target="#addMeasurementPeriodModal">Add Measurement Period</button>

                    </div>
                </div>
                <div class="panel-body">

                    <table id="exampleTablePagination" data-toggle="table"
                           data-query-params="queryParams" data-mobile-responsive="true"
                           data-height="400" data-pagination="true" data-search="true" class="table table-striped datatable"   >
                        <thead>
                        <tr>
                            <th >From</th>
                            <th>To</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($measurement_periods as $measurement_period)



                            <tr>
                                <td >{{date('F-Y',strtotime($measurement_period->from))}}</td>
                                <td >{{date('F-Y',strtotime($measurement_period->to))}}</td>
                                <td>{{date("F j, Y",strtotime($measurement_period->created_at))}}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1"
                                                data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu">
                                            <a style="cursor:pointer;" class="dropdown-item editmp" id="{{$measurement_period->id}}" ><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit Measurement Period</a>
                                            <a style="cursor:pointer;" class="dropdown-item" id="{{$measurement_period->id}}" onclick="deleteMeasurementPeriod(this.id)"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete Measurement Period</a>

                                        </div>
                                    </div></td>
                            </tr>
                        @empty
                        @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    <div class="col-md-12 col-xs-12">

    </div>
</div>
</div>
{{-- Add IP Modal --}}
@include('settings.apersettings.modals.addmeasurementperiod')
@include('settings.apersettings.modals.editmeasurementperiod')
@include('settings.apersettings.modals.addmetric')
{{-- edit IP modal --}}
@include('settings.apersettings.modals.editmetric')
<script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format:'mm-yyyy',
            viewMode: "months",
            minViewMode: "months"
        });

        $('#addMetricForm').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formdata = false;
            if (window.FormData){
                formdata = new FormData(form[0]);
            }
            $.ajax({
                url         : '{{url('apersettings')}}',
                data        : formdata ? formdata : form.serialize(),
                cache       : false,
                contentType : false,
                processData : false,
                type        : 'POST',
                success     : function(data, textStatus, jqXHR){

                    toastr["success"]("Changes saved successfully",'Success');
                    $('#addMetricModal').modal('toggle');
                    $( "#ldr" ).load('{{url('apersettings')}}');
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

        $('#editMetricForm').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formdata = false;
            if (window.FormData){
                formdata = new FormData(form[0]);
            }
            $.ajax({
                url         : '{{url('apersettings')}}',
                data        : formdata ? formdata : form.serialize(),
                cache       : false,
                contentType : false,
                processData : false,
                type        : 'POST',
                success     : function(data, textStatus, jqXHR){

                    toastr["success"]("Changes saved successfully",'Success');
                    $('#editMetricModal').modal('toggle');
                    $( "#ldr" ).load('{{url('apersettings')}}');
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
    function prepareMetricEditData(am_id){
        $.get('{{ url('/apersettings/get_aper_metric') }}',{am_id:am_id},function(data){
            // console.log(data);
            $('#editamid').val(data.id);
            $('#editamname').val(data.name);
            $('#editamfillable').val(data.fillable);
        });
        $('#editMetricModal').modal();
    }
    function deletemetric(am_id){
        alertify.confirm('Are you sure you want to delete this Metric?', function () {


            $.get('{{ url('apersettings/delete_aper_metric') }}',{am_id:am_id},function(data){
                if (data=='success') {
                    toastr["success"]("Metric deleted successfully",'Success');

                    location.reload();
                }else{
                    toastr["error"]("Error deleting Metric",'Success');
                }

            });
        }, function () {
            alertify.error('Metric not deleted');
        });
    }
    $('#addMeasurementPeriodForm').submit(function(e){
        e.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url         : '{{url('apersettings')}}',
            data        : formdata ? formdata : form.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){

                toastr["success"]("Changes saved successfully",'Success');
                $('#addMeasurementPeriodModal').modal('toggle');
                $( "#ldr" ).load('{{url('apersettings')}}');
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
    $('#editMeasurementPeriodForm').submit(function(){
        e.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url         : '{{url('apersettings')}}',
            data        : formdata ? formdata : form.serialize(),
            cache       : false,
            contentType : false,
            processData : false,
            type        : 'POST',
            success     : function(data, textStatus, jqXHR){

                toastr["success"]("Changes saved successfully",'Success');
                $('#editMeasurementPeriodModal').modal('toggle');
                $( "#ldr" ).load('{{url('apersettings')}}');
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

    function prepareMPEditData(mp_id){
        $.get('{{ url('/apersettings/get_aper_measurement_period') }}/',{ mp_id: mp_id },function(data){
            console.log(data);
            $('#editmpfrom').val(formatMPDate(data.from));
            $('#editmpid').val(data.id);
            $('#editmpto').val(formatMPDate(data.to));
        });
        $('#editMeasurementPeriodModal').modal();
    }
    function formatMPDate(date){
        var d = new Date(date);
        month = '' + (d.getMonth() + 1);
        day = '' + d.getDate();
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [month,year].join('-');

    }
    function deleteMeasurementPeriod(measurement_period_id){
        alertify.confirm('Are you sure you want to delete this Measurement Period?', function () {
            $.get('{{ url('/apersettings/delete_aper_measurement_period') }}/',{ mp_id: measurement_period_id },function(data){
                if (data=='success') {
                    toastr.success("Measurement Period deleted successfully",'Success');
                    location.reload();
                }else{
                    toastr.error("Error deleting Measurement Period",'Success');
                }

            });

        }, function () {
            alertify.error('Measurement Period not deleted');
        });

    }

</script>
