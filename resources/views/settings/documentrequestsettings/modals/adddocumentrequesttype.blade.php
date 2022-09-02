<div class="modal fade in modal-3d-flip-horizontal modal-info" id="addDocumentRequestTypeModal" aria-hidden="true" aria-labelledby="addDocumentRequestTypeModal" role="dialog" tabindex="-1">
    <div class="modal-dialog ">
        <form class="form-horizontal" id="addDocumentRequestTypeForm"  method="POST">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="training_title">Add Document Request Type</h4>
                </div>
                <div class="modal-body">
                    <div class="row row-lg col-xs-12">
                        <div class="col-xs-12">
                            @csrf
                            <div class="form-group">
                                <h4 class="example-title">Name</h4>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <h4 class="example-title">Workflow</h4>
                                <select name="workflow_id" id="workflow_id" class="form-control" required>
                                    <option value="">Select  Workflow</option>
                                    @foreach($workflows as $workflow)
                                        <option value="{{$workflow->id}}">{{$workflow->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <h4 class="example-title">Requires Upload</h4>
                                <select name="has_upload" id="has_upload" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>

                                </select>
                            </div>
                            <div class="form-group">
                            <label for="">Groups</label>
                            <select class="form-control group-multiple" id="group_id" name="group_id[]" multiple style="width:100%;">
                              @forelse ($groups as $group)
                                <option value="{{$group->id}}">{{$group->name}}</option>
                              @empty
                                <option value="">No Groups Created</option>
                              @endforelse
                            </select>
                            <!-- <p class="help-block">Help text here.</p> -->
                          </div>
                        </div>
                        <div class="clearfix hidden-sm-down hidden-lg-up"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-xs-12">

                        <div class="form-group">
                            <input type="hidden" name="type" value="save_document_request_type">
                            <button type="submit" class="btn btn-info pull-left">Save</button>
                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        </div>
                        <!-- End Example Textarea -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
