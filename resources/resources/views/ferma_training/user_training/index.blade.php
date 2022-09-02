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


        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            font-size: 24px;
        }
        .rating > span {
            display: inline-block;
            position: relative;
            width: 1.1em;
        }
        .rating > span:hover:before,
        .rating > span:hover ~ span:before {
            content: "\2605";
            position: absolute;
        }


        .rating > span.selected:before,
        .rating > span.selected ~ span:before {
            content: "\2605";
            position: absolute;
        }

    </style>


    <!-- Page -->
    <div class="page">

        <div class="row">

            {{--<div class="col-md-2">--}}

            {{--</div>--}}

            <div class="col-md-12">


                @foreach ($list as $item)
                    @include('ferma_training.user_training.edit')
                @endforeach

                <div class="page-header" style="padding-bottom: 0;">
                    <h1 class="page-title" style="text-transform: uppercase;">My Trainings</h1>
                </div>


                <div class="page-content container-fluid" style="padding-top: 29px;">

                    <div class="col-sm-12" style="
    background-color: #fff;
    padding: 31px;
">

                        <div class="col-md-12" align="right">
                            {{--<button style="margin-bottom: 11px;" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-plan">Add Training Plan</button>--}}
                        </div>

                        <table class="table table-striped" style="border: 1px solid #eee;">
                            <tr>
                                <th>
                                    Name Of Training
                                </th>
                                <th>
                                    Feedback
                                </th>
                                <th>
                                    Rating
                                </th>
                                <th>
                                    Completed
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                            @foreach ($list as $item)
                                <tr data-each="userTraining">
                                    <td>
                                        {{ $item->training_plan->name_of_training }}
                                    </td>
                                    <td>
                                        {{ $item->feedback }}
                                    </td>
                                    <td>
                                        <div class="rating"  data-rating="{{ $item->rating }}">
                                            <span data-val="5">☆</span><span data-val="4">☆</span><span data-val="3">☆</span><span data-val="2">☆</span><span data-val="1">☆</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->completed)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit{{ $item->id }}">Send Feedback</a>
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

        function userTraining($el){

            var $stars = $el.find('.rating').find('span');
            var $ratval = $el.find('#ratval');

            function updateRating(rt) {
                // if (rt){
                //     return;
                // }
                // rt = 5 - rt;
                $stars.removeClass('selected');
                $stars.each(function (k,v) {
                    if (k == rt){
                        $(this).addClass('selected');
                        $ratval.val($(this).attr('data-val'));
                    }
                });
            }

            var vl = $el.find('.rating').attr('data-rating');

            // alert(vl);
            if (vl){
                vl = +vl;
                vl = 5 - vl;
                updateRating(+vl);
            }


            $stars.each(function (k,v) {
                $(this).on('click',function () {
                    updateRating(k);
                });
            });




        }

    </script>

    @include('ferma_training.script')

@endsection