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
            <h1 class="page-title">Promotions for {{ $year }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item active">Promotions for {{ $year }}</li>
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

            <div class="row h-full">
                <div class="col-xxl-12 col-lg-4 h-p50 h-only-lg-p100 h-only-xl-p100">
                    <!-- Panel Overall Sales -->
                    <div class="card card-shadow card-inverse bg-blue-600 white">
                        <a href="{{ route('promotion.by.exam') }}" class="card-block p-30" style="text-decoration: none; color: white" >
                            <div class="counter counter-lg counter-inverse text-left">
                                <div class="counter-label mb-20">
                                    <div>PROMOTION</div>
                                </div>
                                <div class="counter-number-group mb-15">
                                    <span class="counter-number">BY EXAM</span>
                                </div>
                                <!--<div class="counter-label">
                                    <div class="counter counter-sm text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-number font-size-14">42%</span>
                                            <span class="counter-number-related font-size-14">HIGHER THAN LAST MONTH</span>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </a>
                    </div>
                    <!-- End Panel Overall Sales -->
                </div>

                <div class="col-xxl-12 col-lg-4 h-p50 h-only-lg-p100 h-only-xl-p100">
                    <!-- Panel Today's Sales -->
                    <div class="card card-shadow card-inverse bg-red-600 white">
                        <a href="{{ route('promotion.by.advancement') }}" class="card-block p-30" style="text-decoration: none; color: white" >
                            <div class="counter counter-lg counter-inverse text-left">
                                <div class="counter-label mb-20">
                                    <div>PROMOTION</div>
                                </div>
                                <div class="counter-number-group mb-10">
                                    <span class="counter-number">By Advancement</span>
                                </div>
                                <!--<div class="counter-label">
                                    <div class="counter counter-sm text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-number font-size-14">70%</span>
                                            <span class="counter-number-related font-size-14">HIGHER THAN LAST MONTH</span>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </a>
                    </div>
                    <!-- End Panel Today's Sales -->
                </div>
                <div class="col-xxl-12 col-lg-4 h-p50 h-only-lg-p100 h-only-xl-p100">
                    <!-- Panel Today's Sales -->
                    <div class="card card-shadow card-inverse bg-red-600 white">
                        <a href="{{ route('promotion.by.exam') }}" class="card-block p-30" style="text-decoration: none; color: white" >
                            <div class="counter counter-lg counter-inverse text-left">
                                <div class="counter-label mb-20">
                                    <div>Promotion</div>
                                </div>
                                <div class="counter-number-group mb-10">
                                    <span class="counter-number">By Conversion/Upgrading</span>
                                </div>
                                <!--<div class="counter-label">
                                    <div class="counter counter-sm text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-number font-size-14">70%</span>
                                            <span class="counter-number-related font-size-14">HIGHER THAN LAST MONTH</span>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </a>
                       </div>
                    </div>
                    <!-- End Panel Today's Sales -->
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
    </script><script src="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('global/vendor/jt-timepicker/jquery.timepicker.min.js')}}"></script>
    <script src="{{asset('global/vendor/datepair/datepair.min.js')}}"></script>
    <script src="{{asset('global/vendor/datepair/jquery.datepair.min.js')}}"></script>
@endsection