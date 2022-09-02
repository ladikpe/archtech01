<form data-each="trainingPlanForm" action="{{ route('call.service',['tr_training_settings:saveSetting']) }}" method="post">

    @csrf

<div id="setting" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Setting</h4>
            </div>
            <div class="modal-body">


                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Name/Key
                                </label>
                                <input type="text" name="key" class="form-control" placeholder="Name/Key" />
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Content
                                </label>
                                <input type="text" name="content" class="form-control" placeholder="Content/Value" />
                            </div>
                        </div>
                    </div>


                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>
</div>

</form>
