@extends('layouts.master')
@section('stylesheets')
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-maxlength/bootstrap-maxlength.css')}}">
    <link rel="stylesheet" href="{{ asset('global/vendor/jt-timepicker/jquery-timepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('global/vendor/datatables/datatables.min.css')}}">
    <style>
        td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
@endsection
@section('content')
    <!-- Page -->
    <div class="page ">
        <div class="page-header">
            <h1 class="page-title">{{ ucfirst($type) }} Promotion List for {{ $year }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item active">{{ $type }} Promotion List for {{ $year }}</li>
            </ol>
            <div class="page-header-actions">
                <div class="row no-space w-350 hidden-sm-down">
                    <div class="col-sm-9 col-xs-12">
                        <form method="GET" action="{{route("promotions.index")}}" style="text-align: right">
                            <div class="col-md-9">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="icon fa fa-calendar" aria-hidden="true"></i>
                                </span>
                                    <input type="text" class="form-control datepair-date datepair-start" id="date2"
                                           data-plugin="datepicker" name="year" autocomplete="off"
                                           placeholder="{{ $year }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-lg-3 masonry-item">
                    <div class="panel" id="messge">
                        <div class="panel-heading">
                            <div class="panel-actions panel-actions-keep">
                                @if($year==\Carbon\Carbon::today()->format('Y'))
                                    <button href="sss" class="btn btn-primary" onclick="generateEligibleStaff()" type="button">Generate Eligible Staff</button>
                                @endif
                            </div>
                            <h3 class="panel-title">Ranks</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group list-group-full h-500" data-plugin="scrollable">
                                <div data-role="container">
                                    <div data-role="content" id="table1">
                                        <input type="text" id="search1" name="example-input3-group2" class="form-control" placeholder="Search">
                                        @foreach($ranks as $rank)
                                            <a href="javascript:void(0)" onclick="loadRankData({{$rank->id}})" class="list-group-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h5 class="list-group-item-heading mt-0 mb-0">
                                                           {{ $rank->name }}
                                                        </h5>
                                                        <p class="list-group-item-text">Cadre:{{ $rank->cadre->name }}</p>
                                                        <p class="list-group-item-text">Grade: {{ $rank->grade->level }}</p>
                                                        <p class="list-group-item-text">No of Staff: {{ $rank->current_rank_promotion_exam_count }}{{ $rank->current_rank_promotion_advance_count }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-xs-12 col-md-9" id="promotion_list"></div>
            </div>

            <br>


        </div>
    </div>

    <div class="modal fade in modal-3d-flip-horizontal modal-info" id="uploadResultModal" aria-hidden="true"
         aria-labelledby="uploadShiftScheduleModal" role="dialog" tabindex="-1">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="training_title">Import Promotions</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-row">
                                <p>Click on the button below to download an excel template. Fill the template, save it and upload back to the system</p>
                                <button class="btn btn-info">
                                    <a style="text-decoration: none; color: white"  href='{{route('promotion.template')}}'> Download Template</a>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form class="form-horizontal" id="uploadResultForm" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="form-control-label" for="inputBasicFirstName">Upload Staff Exam Scores</label>
                                        <input type="file" name="template" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <button type="submit" id="submit_button" class="btn btn-info pull-left">Upload</button>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div id="loader" style="display: none;"
                                         class="loader vertical-align-middle loader-ellipsis"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-xs-12">


                        <!-- End Example Textarea -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#date2").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            orientation: "bottom"
        });
    </script>
    <script>
        $('#uploadResultForm').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $("#submit_button").hide();
            $("#loader").show();
            $.ajax({
                url: '{{route('promotion.template.import')}}',
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data, textStatus, jqXHR) {
                    toastr.success("Changes saved successfully", 'Success');
                    $("#submit_button").show();
                    $("#loader").hide();
                    $('#uploadResultModal').modal('toggle');
                },
                error: function (data, textStatus, jqXHR) {
                    $("#loader").hide();
                    $("#submit_button").show();
                    jQuery.each(data['responseJSON'], function (i, val) {
                        jQuery.each(val, function (i, valchild) {
                            toastr.error(valchild[0]);
                        });
                    });
                }
            });

        });
        function loadRankData(rank) {
            url = '{{url('promotion/rank/year')}}?rank='+rank+'&year='+'{{ $year }}'+'&type='+'{{ $type }}',
                $("#promotion_list").load(url, function() {
                    console.log('done');
                });
        }
        function generateEligibleStaff() {
            var r = confirm("Are you sure you want to generate Staff Eligible for Promotion?");
            if (r == true) {
                generateEligibleStaffTrue()
            } else {
                toastr.error('It was not approved');
            }
        }

        function generateEligibleStaffTrue(){
            var token = '{{csrf_token()}}';
            senddata={'_token':token,};
            $.ajax({
                url: '{{route('populate.eligible')}}',
                type: 'GET',
                success: function (data, textStatus, jqXHR) {
                    toastr.success("Changes saved successfully", 'Success');
                    /*  setTimeout(function () {
                       window.location.reload();
                   }, 2000);*/
                },
                error: function (data, textStatus, jqXHR) {
                    jQuery.each(data['responseJSON'], function (i, val) {
                        jQuery.each(val, function (i, valchild) {
                            toastr.error(valchild[0]);
                        });
                    });
                }
            });
        }
    </script>
    <script>
        $(document).ready(function(){
            $("#search1").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table1 a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('global/vendor/jt-timepicker/jquery.timepicker.min.js')}}"></script>
    <script src="{{asset('global/vendor/datepair/datepair.min.js')}}"></script>
    <script src="{{asset('global/vendor/datepair/jquery.datepair.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js')}}"></script>

@endsection