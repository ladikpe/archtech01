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
                    <h3 class="panel-title">Sub Metrics for {{$metric->name}}</h3>
                    <div class="panel-actions">
                        <button class="btn btn-info" data-toggle="modal" data-target="#addSubMetricModal">Add Sub Metric</button>

                    </div>
                </div>
                <div class="panel-body">

                    <table id="exampleTablePagination" data-toggle="table"
                           data-query-params="queryParams" data-mobile-responsive="true"
                           data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                        <thead>
                        <tr>
                            <th >Name:</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($submetrics as $asm)
                            <tr>
                                <td>{{$asm->name}}</td>

                                <td><a class="" title="edit" class="btn btn-icon btn-info" id="{{$asm->id}}" onclick="prepareSubMetricEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a class="" title="delete" class="btn btn-icon btn-danger" id="{{$asm->id}}" onclick="deletesubmetric(this.id);"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach

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

@include('settings.apersettings.modals.editsubmetric')
@include('settings.apersettings.modals.addsubmetric')

<script type="text/javascript">
    $(function() {

        $('#addSubMetricForm').submit(function(e){
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
                    $('#addSubMetricModal').modal('toggle');
                    $( "#ldr" ).load('{{url('apersettings/aper_sub_metrics')."?am_id=".$metric->id}}');
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

        $('#editSubMetricForm').submit(function(e){
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
                    $('#editSubMetricModal').modal('toggle');
                    $( "#ldr" ).load('{{url('apersettings/aper_sub_metrics')."?am_id=".$metric->id}}');
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
    function prepareSubMetricEditData(asm_id){
        $.get('{{ url('/apersettings/get_sub_metric') }}',{asm_id:asm_id},function(data){
            // console.log(data);
            $('#editasmid').val(data.id);
            $('#editasmname').val(data.name);
        });
        $('#editSubMetricModal').modal();
    }
    function deletesubmetric(am_id){
        alertify.confirm('Are you sure you want to delete this Sub Metric?', function () {


            $.get('{{ url('apersettings/delete_sub_metric') }}',{am_id:am_id},function(data){
                if (data=='success') {
                    toastr["success"]("Sub Metric deleted successfully",'Success');

                    location.reload();
                }else{
                    toastr["error"]("Error deleting Sub Metric",'Success');
                }

            });
        }, function () {
            alertify.error('Sub Metric not deleted');
        });
    }

</script>
