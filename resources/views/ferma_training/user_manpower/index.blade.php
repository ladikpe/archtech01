@extends('layouts.master')
@section('stylesheets')

    <style type="text/css">

        .margin{
            margin-bottom:5px;
        }

        .hide{
            display: none;
        }

    </style>

    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-markdown/bootstrap-markdown.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/switchery/switchery.css')}}">

    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-table/bootstrap-table.css')}}">

    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert.css')}}">

@endsection

@section('content')

    <style>
        .info1 p{
            margin: 0;
        }

        .my-badge{

            display: inline-block;
            background-color: #ddd;
            padding: 2px;
            border-radius: 20%;
            padding-left: 6px;
            padding-right: 7px;

        }
    </style>


    <!-- Page -->
    <div class="page">

        <div class="row">

            {{--<div class="col-md-2">--}}

            {{--</div>--}}

            <div class="col-md-12">

                {!! $budget !!}

                @include('ferma_training.plan.create')



                @foreach ($list as $item)
                    @include('ferma_training.plan.edit')
                @endforeach

                <div class="page-header" style="padding-bottom: 0;">
                    <h1 class="page-title" style="text-transform: uppercase;">Training Budget</h1>
                </div>


                <div class="page-content container-fluid" style="padding-top: 29px;">

                    <div class="col-sm-12" style="
    background-color: #fff;
    padding: 31px;
">

                        <div class="col-md-12" align="right">
                            <button style="margin-bottom: 11px;" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#budget">Manage Budget</button>
                            <button style="margin-bottom: 11px;" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-plan">Add Training Plan</button>
                        </div>

                        <table class="table table-striped" style="border: 1px solid #eee;">
                            <tr>
                                <th>
                                    Year Of Training
                                </th>
                                <th>
                                    Name Of Training
                                </th>
                                <th>
                                    Enrollees
                                </th>
                                <th>
                                    Cadre
                                </th>
                                <th>
                                    Work-Flow
                                </th>
                                <th>
                                    Total Amount
                                </th>
                                <th>
                                    Remark
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                            @foreach ($list as $item)
                                <tr>
                                    <td>
                                        {{ $item->year_of_training }}
                                    </td>
                                    <td>
                                        {{ $item->name_of_training }}
                                    </td>
                                    <td>
                                        {{ $item->number_of_participants }}
                                    </td>
                                    <td>
                                        {{ $item->cadre->name }}
                                    </td>
                                    <td>
                                        {{ $item->workflow->name }}
                                    </td>
                                    <td>
                                        {{ $item->total_cost }}
                                    </td>
                                    <td>
                                        @if ($item->iswithinBudget())
                                           Is Within Budget
                                        @else
                                           Exceeds Budget
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->getApprovalStatus() }}
                                    </td>

                                    <td>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit-plan{{ $item->id }}">Edit</a>
                                        <a onclick="return confirm('Do you want to confirm this action?')" href="{{ route('call.service',['tr_training_plan:removeTrainingPlan']) }}?id={{ $item->id }}" class="btn btn-sm btn-danger">Remove</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>


                        <div>
                            {{ $list->links() }}
                        </div>


                    </div>
                </div>


            </div>

            {{--<div class="col-md-2"></div>--}}


        </div>


    </div>
    <!-- End Page -->
@endsection

@section('scripts')

    <script>

        function trainingPlanForm($el){

            var $number_of_participants = $el.find('[name=number_of_participants]');
            var $cost_per_head = $el.find('[name=cost_per_head]');
            var $total_cost = $el.find('[name=total_cost]');
            var $total_cost_ = $el.find('#total_cost');

            // alert('called');

            function updateTotalCost(){
                $total_cost.val($number_of_participants.val() * $cost_per_head.val());
                $total_cost_.html(($number_of_participants.val() * $cost_per_head.val()).toLocaleString());
                // alert($number_of_participants.val() * $cost_per_head.val());
            }

            $number_of_participants.on('keyup',function(){
                updateTotalCost();
            });


            $cost_per_head.on('keyup',function(){
                updateTotalCost();
            });

            updateTotalCost();

        }

    </script>

    @include('ferma_training.script')

@endsection