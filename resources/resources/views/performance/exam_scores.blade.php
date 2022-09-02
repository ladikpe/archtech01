@extends('layouts.master')
@section('stylesheets')
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-maxlength/bootstrap-maxlength.css')}}">
    <link rel="stylesheet" href="{{ asset('global/vendor/jt-timepicker/jquery-timepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('global/vendor/datatables/datatables.min.css')}}">
@endsection
@section('content')
    <!-- Page -->
    <div class="page ">
        <div class="page-header">
            <h1 class="page-title">{{__('Exam Scores')}}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item active">{{__('Exam Scores')}}</li>
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
                <div class="col-lg-8"></div>
                <div class="col-lg-4">
                    <form method="GET" action="{{url("/monthly/attendance/reports")}}" style="text-align: right">
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="icon fa fa-calendar" aria-hidden="true"></i>
                                </span>
                                <input type="text" class="form-control datepair-date datepair-start" id="date2"
                                       data-plugin="datepicker" name="date" autocomplete="off"
                                       placeholder="{{ $year }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <br>
            <div class="col-md-12 col-xs-12 col-md-12">
                <div class="panel panel-info panel-line">
                    <div class="panel-heading">
                        <h3 class="panel-title">Exam Scores List</h3>
                        <div class="panel-actions">
                            <button class="btn btn-info" data-toggle="modal" data-target="#uploadResultModal">
                                Import Exam Scores With Excel
                            </button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                                <thead>
                                <tr>

                                    <th>S/N</th>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Score</th>
                                    <th>Current Rank</th>
                                    <th>Aspiring Rank</th>
                                    <th>Year</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody  id="directempsbody">
                                @forelse($scores as $score)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$score->user->emp_num}} </td>
                                        <td>{{$score->user->name}}</td>
                                        <td>{{$score->score}} </td>
                                        <td>{{$score->user->rank->name}} </td>
                                        <td>{{$score->user->aspiring_rank()['name']}} </td>
                                        <td>{{$score->year}}</td>
                                        <td>{{$score->status}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align: center">
                                            <h3 style="">No Exam Score Uploaded for this year.</h3>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade in modal-3d-flip-horizontal modal-info" id="uploadResultModal" aria-hidden="true"
         aria-labelledby="uploadShiftScheduleModal" role="dialog" tabindex="-1">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="training_title">Import Exam Scores</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-row">
                                <p>Click on the button below to download an excel template. Fill the template, save it and upload back to the system</p>
                                <button class="btn btn-info">
                                    <a style="text-decoration: none; color: white"  href='{{route('exam.stores.template')}}'> Download Template</a>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form class="form-horizontal" id="uploadResultForm" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="form-control-label" for="inputBasicFirstName">Upload Staff Exam Score</label>
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
                url: '{{route('exam.scores.import')}}',
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
    </script>
    <script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('global/vendor/jt-timepicker/jquery.timepicker.min.js')}}"></script>
    <script src="{{asset('global/vendor/datepair/datepair.min.js')}}"></script>
    <script src="{{asset('global/vendor/datepair/jquery.datepair.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js')}}"></script>
@endsection