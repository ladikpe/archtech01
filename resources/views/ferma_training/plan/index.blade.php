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

                @if ($approval)
                 {!! $budget !!}
                @endif


                @if (!$approval)
                    @include('ferma_training.plan.create')
                @endif




                @foreach ($list as $item)

                        @php
                         $selectedUsers = $item->getSelectedUsers();
                        @endphp

                        @include('ferma_training.plan.edit')

                        @if ($approval)
                          {!! $approvalView($item) !!}
                        @endif

                @endforeach

                <div class="page-header" style="padding-bottom: 0;">
                    <h1 class="page-title" style="text-transform: uppercase;">{{ $approval? '':'Upload' }} Training Plan {{ $approval? 'Approval' : '' }}</h1>
                </div>


                <div class="page-content container-fluid" style="padding-top: 29px;">

                    <div class="col-sm-12" style="
    background-color: #fff;
    padding: 31px;
">

                        <div class="col-md-12" align="right">
                            @if ($approval)
                              <button style="margin-bottom: 11px;" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#budget">Manage Budget</button>
                            @endif
                            @if (!$approval)
                              <button style="margin-bottom: 11px;" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-plan">Add Training Plan</button>
                            @endif
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
                                    Type
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
                                    Stage
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
                                        {{ $item->type }}
{{--                                        {{ $item->cadre? $item->cadre->name : 'N/A' }}--}}
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
                                        {{ $item->getCurrentStage() }}
                                    </td>

                                    <td>

                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit-plan{{ $item->id }}">{{ $approval? 'Detail' : 'Edit' }} </a>

                                        @if ($approval)
                                          <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#approval{{ $item->id }}">Approve</a>
                                        @else
                                          <a onclick="return confirm('Do you want to confirm this action?')" href="{{ route('call.service',['tr_training_plan:removeTrainingPlan']) }}?id={{ $item->id }}" class="btn btn-sm btn-danger">Remove</a>
                                        @endif
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
            var $user_id = $el.find('#user_id');

            //var $user_id_grp = $el.find()

            var $user_group = $el.find('#user_group');
            var $type = $el.find('#type');
            var $group_id = $el.find('#user_group_user');
            var $cadre_id = $el.find('#cadre_group');
            var $cadre_group = $cadre_id;

            var $group_id_ = $el.find('#group_id');
            var $cadre_id_ = $el.find('[name=cadre_id]');

            var $group_type_user = $el.find('#group_type_user');
            var $group_type_group = $el.find('#group_type_group');
            var $user_group_group = $el.find('#user_group_group');
            var $group_type_cadre = $el.find('#group_type_cadre');


            //'data', {id: '123', text: 'res_data.primary_email'}


            //user_group_user


            // alert('called');


            $group_id_.on('change',function(){


                $.ajax({
                    url:'{{ route('training.get',['get-group-users']) }}?id=' + $(this).val(),
                    type:'GET',
                    success:function(response){
                        $number_of_participants.val(response.data.length);
                    }
                });


            });

            $cadre_id_.on('change',function(){


                $.ajax({
                    url:'{{ route('training.get',['get-cadre-users']) }}?id=' + $(this).val(),
                    type:'GET',
                    success:function(response){
                        $number_of_participants.val(response.data.length);
                    }
                });


            });

            function updateTotalCost(){
                if ($type.val() == 'empowerment'){

                    // alert('seen');

                    var cnt = $user_id.find('option:selected').length;
                    // alert(cnt);

                    $number_of_participants.val(1);

                    if (cnt){
                        $number_of_participants.val(cnt);
                    }
                    // return;
                }
                // alert($type.val());
                $total_cost.val($number_of_participants.val() * $cost_per_head.val());
                $total_cost_.html(($number_of_participants.val() * $cost_per_head.val()).toLocaleString());
                // alert($number_of_participants.val() * $cost_per_head.val());
            }

            $number_of_participants.on('keyup',function(){
                updateTotalCost();
            });

            $group_type_group.on('click change',function(){
                $user_group.hide();
                $group_id.show();
                $cadre_group.hide();
            });

            $group_type_user.on('click change',function(){
                $user_group.show();
                $group_id.hide();
                $cadre_group.hide();
                // alert(2);
            });

            //cadre_group

            $group_type_cadre.on('change click',function(){
                $user_group.hide();
                // alert('changed...');
                $group_id.hide();
                $cadre_group.show();
            });

            // $group_type_user.on('change',function(){
            //     $user_group.show();
            //     $group_id.hide();
            // });

            $group_type_user.prop('checked',true);
            $group_type_user.trigger('click');
            // $group_id.hide();




            $cost_per_head.on('keyup',function(){
                updateTotalCost();
            });

            function updateTypeSelection(vl){
                if (vl == 'group'){
                    $user_group.hide();
                    $group_id.hide();
                    $cadre_id.show();
                    $user_group_group.hide();
                }else if (vl == 'empowerment'){
                    $number_of_participants.val(1);
                    $user_group.show();
                    if ($group_type_user.prop('checked')){
                      //$group_type_user.prop
                      $group_id.hide();
                      $user_group.show();
                    }else{
                      $group_id.show();
                      $user_group.hide();
                    }

                    if ($group_type_group.prop('checked')){
                        $group_id.show();
                        $user_group.hide();
                    }else{
                        $group_id.hide();
                        $user_group.show();
                    }

                    // $group_id.show();
                    // $cadre_id.hide();
                    $user_group_group.show();
                }
            }

            $type.on('change',function(){
                // alert(11);
                updateTypeSelection($(this).val());
                updateTotalCost();
            });

            updateTypeSelection($type.val());



            $user_id.select2({
                ajax: {
                    url: '{{ route('ajax.search.user') }}',
                    minimumInputLength:3,
                    dataType:'json',
                    data: function (params) {
                        var query = {
                            search: params.term
                        }
                        // Query parameters will be ?search=[term]&page=[page]
                        return query;
                    }
                }
            });

            // $user_id.select2('data', {id: '123', text: 'res_data.primary_email'});

            //'data', {id: '123', text: 'res_data.primary_email'}


            $user_id.on('change',function(){

                updateTotalCost();

            });

            updateTotalCost();

        }

    </script>

    @include('ferma_training.script')

@endsection