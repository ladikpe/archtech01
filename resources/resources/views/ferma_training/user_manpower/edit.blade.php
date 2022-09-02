<form data-each="trainingPlanForm" action="{{ route('call.service',['tr_training_plan:updateTrainingPlan']) }}" method="post">

    @csrf

    <input type="hidden" name="id" value="{{ $item->id }}" />

    <div id="edit-plan{{ $item->id }}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-info modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Training Plan</h4>
                </div>
                <div class="modal-body">


                    <div class="col-md-12">



                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Year Of Training
                                    </label>
                                    <div style="border: 1px solid #eee;padding: 9px;">
                                        {{ $item->year_of_training }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Name Of Training
                                    </label>
                                    <input type="text" class="form-control" placeholder="Name Of Training" name="name_of_training" value="{{ $item->name_of_training }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Select WorkFlow
                                    </label>
                                    <select name="workflow_id" class="form-control" id="" data-value="{{ $item->workflow_id }}">
                                        <option value="">--Select--</option>
                                        @foreach ($workflows as $workflow)
                                            <option value="{{ $workflow->id }}">{{ $workflow->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Select Cadre
                                    </label>
                                    <select name="cadre_id" class="form-control" id="" data-value="{{ $item->cadre_id }}">
                                        <option value="">--Select--</option>
                                        @foreach ($cadres as $cadre)
                                            <option value="{{ $cadre->id }}">{{ $cadre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Number Of Participants
                                    </label>
                                    <input type="text" class="form-control" placeholder="Number Of Participants" name="number_of_participants" value="{{ $item->number_of_participants }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        Cost Per Head
                                    </label>
                                    <input type="text" class="form-control" placeholder="Cost Per Head" name="cost_per_head" value="{{ $item->cost_per_head }}" />
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="">
                                Total Cost
                            </label>
                            <div id="total_cost" style="border: 1px solid #eee;padding: 9px;">
                                {{ $item->total_cost }}
                            </div>
                            <input readonly type="hidden" name="total_cost" class="form-control" placeholder="Total Cost" value="{{ $item->total_cost }}" />
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>

        </div>
    </div>
</form>
