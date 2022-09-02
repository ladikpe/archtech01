<div id="budget" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Training Budget</h4>
            </div>
            <div class="modal-body">


                <div class="row">

                    <div class="col-md-12">


                        <div class="page-header" style="padding-bottom: 0;padding: 0">
                            <h1 class="page-title" style="text-transform: uppercase;">Training Budget</h1>
                        </div>


                        <div class="page-content container-fluid" style="padding-top: 29px;padding: 0">

                            <div class="col-sm-12" style="background-color: #fff;">

                                <div class="col-md-12" align="right">
                                    <button style="margin-bottom: 11px;" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-budget">Add Budget</button>
                                </div>

                                <table class="table table-striped" style="border: 1px solid #eee;">
                                    <tr>
                                        <th>
                                            Cadre
                                        </th>
                                        <th>
                                            Year
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>
                                                {{ $item->cadre->name }}
                                            </td>
                                            <td>
                                                {{ $item->year }}
                                            </td>
                                            <td>
                                                {{ $item->total_amount }}
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit-budget{{ $item->id }}">Edit</a>
                                                <a onclick="return confirm('Do you want to confirm this action?')" href="{{ route('call.service',['tr_training_budget:removeTrainingBudget']) }}?id={{ $item->id }}" class="btn btn-sm btn-danger">Remove</a>
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

@foreach ($list as $item)
    @include('ferma_training.budget.edit')
@endforeach
@include('ferma_training.budget.create')