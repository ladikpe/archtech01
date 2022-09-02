<div id="approval{{ $item->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Approval Stages ( {{ $item->name_of_training }} )</h4>
            </div>
            <div class="modal-body">


                <div class="row">

                    <div class="col-md-12">


                        {{--<div class="page-header" style="padding-bottom: 0;padding: 0">--}}
                            {{--<h1 class="page-title" style="text-transform: uppercase;"></h1>--}}
                        {{--</div>--}}


                        <div class="page-content container-fluid" style="padding-top: 29px;padding: 0">

                            <div class="col-sm-12" style="background-color: #fff;">

                                {{--<div class="col-md-12" align="right">--}}
                                    {{--<button style="margin-bottom: 11px;" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-budget">Add Budget</button>--}}
                                {{--</div>--}}

                                <table class="table table-striped" style="border: 1px solid #eee;">
                                    <tr>
                                        <th>
                                            Pointer
                                        </th>
                                        <th>
                                            Stage
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Approved By
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    @foreach ($list as $k=>$item)
                                        <tr>
                                            <td>
                                                @if ($k == 0)
                                                  @if ($item->status == 1)
                                                     <i style="color: green;">Passed</i>
                                                  @else
                                                     Current
                                                  @endif

                                                @else
                                                    <i style="color: green;">Passed</i>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->stage->name }}
                                            </td>
                                            <td>
                                                @if ($item->status == 0)
                                                   Pending Approval
                                                @endif

                                                @if ($item->status == 1)
                                                    Approved
                                                @endif

                                                @if ($item->status == 2)
                                                     Rejected
                                                @endif

                                            </td>
                                            <td>
                                                {{ $item->getApprovedBy() }}
                                            </td>
                                            <td>
                                                @if ($item->status != 1)
                                                  <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#approve-reject{{ $item->id }}">Approve / Reject</a>
                                                @else
                                                   <b style="color: green;">Done</b>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>


                            </div>
                        </div>


                    </div>



                </div>


            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>
</div>
@php
 $trainingPlan = $trainingPlanObject;
@endphp
@foreach ($list as $item)
    @include('ferma_training.approvals.edit')
@endforeach
