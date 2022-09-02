@extends('layouts.master')
@section('stylesheets')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
    <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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
   
    .list-group{

        overflow:auto;
    }
    .overflow{
        overflow:auto;
    }
</style>

@endsection
@section('content')
    <div class="page ">
        <div class="page-header">
            <h1 class="page-title">APER Evaluation Histroy for Eligible Staff</h1>
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

                <div class="col-md-3">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="panel panel-info ">
                        <div class="panel-heading main-color-bg">
                            <h3 class="panel-title">Cadres</h3>
                        </div>


                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="list-group bg-grey-200 bg-inherit h-500" >
                                    @foreach($cadres as $cadre)
                                  <a class="list-group-item grey-600" href="javascript:void(0)" onclick="getRanks({{$cadre->id}},'{{$cadre->name}}');">
                                  <i class="icon md-inbox" aria-hidden="true"></i> {{$cadre->name}}
                                </a>
                                    @endforeach
                                 
                                </div>
                            </div>



                        </div>


                    </div>


                </div>
                 <div class="col-md-3">
                     <div class="panel panel-info ">
                        <div class="panel-heading main-color-bg">
                            <h3 class="panel-title" id="rank_title">Ranks</h3>
                        </div>


                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="list-group bg-grey-200 bg-inherit h-500"  id='ranks'>
                                  <a class="list-group-item grey-600" href="javascript:void(0)" >
                                  <i class="icon md-inbox" aria-hidden="true"></i> Please Select Cadre
                                </a> 
                                 
                                </div>
                            </div>



                        </div>


                    </div>
                     </div>
                      <div class="col-md-6">
                     <div class="panel panel-info ">
                        <div class="panel-heading main-color-bg">
                            <h3 class="panel-title" id="staff_title">Employees</h3>
                        </div>


                        <div class="panel-body">
                            <div class="col-md-12 h-500  overflow" id="users">
                                
                            </div>



                        </div>


                    </div>
                     </div>
            </div>

        </div>


    </div>

@endsection
@section('scripts')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('global/vendor/select2/select2.min.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.input-daterange').datepicker({
                autoclose: true
            });
            $('.select2').select2();
            var selected = [];

            $('.active-toggle').change(function() {
                var id = $(this).attr('id');
                var isChecked = $(this).is(":checked");
                console.log(isChecked);
                $.get(
                    '{{ route('workflows.alter-status') }}',
                    { id: id, status: isChecked },
                    function(data) {
                        if(data=="enabled"){
                            toastr.success('Enabled!', 'Workflow Status');
                        }
                        if(data=="disabled"){
                            toastr.error('Disabled!', 'Workflow Status')
                        }else{
                            toastr.error(data, 'Workflow Status');

                        }


                    }
                );

            });
            $('#user').select2({
                ajax: {
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    url: function (params) {
                        return '{{url('bsc/usersearch')}}';
                    }
                }
            });
        } );
        function getRanks(cadre_id,cadre_name) {
            document.querySelector("#rank_title").innerHTML="Ranks in "+cadre_name+" Cadre";
           
        url = '{{url('aper/get_eligible_users_cadre_ranks')}}?cadre_id='+cadre_id,
            $("#ranks").load(url, function() {
                console.log('done');
            });
    }
    function getStaff(rank_id,rank_name) {
        document.querySelector("#staff_title").innerHTML="Employees in "+rank_name+" Rank";
        url = '{{url('aper/get_eligible_ranks_users')}}?rank_id='+rank_id,
            $("#users").load(url, function() {
                console.log('done');
            });
    }

    </script>
    <script src="{{asset('global/js/Plugin/table.min.js')}}"></script>
@endsection
