<form onsubmit="return confirm('Do you want to confirm this action?')"  action="{{ route('call.service',['tr_training_plan_approvals:runApproval']) }}" method="post">

    @csrf

    <input type="hidden" name="id" value="{{ $item->id }}" />

    <div id="approve-reject{{ $item->id }}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-info modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Approve / Reject Training ({{ $trainingPlan->name_of_training }})</h4>
                </div>
                <div class="modal-body">


                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Your Comments
                                    </label>
                                    <textarea name="comments" class="form-control">{{ $item->comments }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Approve
                                        <input type="radio" name="status" value="1" />
                                    </label>
                                    <label for="">
                                        Reject
                                        <input type="radio" name="status" value="2" />
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>

        </div>
    </div>
</form>
