<form data-each="userTraining" action="{{ route('call.service',['tr_user_training:updateFeedback']) }}" method="post">

    @csrf

    <input type="hidden" name="id" value="{{ $item->id }}" />

    <div id="edit{{ $item->id }}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-info modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send Feedback ({{ $item->training_plan->name_of_training }})</h4>
                </div>
                <div class="modal-body">


                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Feedback
                                    </label>
                                    <textarea name="feedback" class="form-control">{{ $item->feedback }}</textarea>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Rating
                                    </label>
                                    <div class="rating"  data-rating="{{ $item->rating }}">
                                        <span data-val="5">☆</span><span data-val="4">☆</span><span data-val="3">☆</span><span data-val="2">☆</span><span data-val="1">☆</span>
                                    </div>

                                    <input type="hidden" class="form-control" placeholder="Rating" id="ratval" name="rating" value="{{ $item->rating }}" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">
                                        Completed
                                    </label>
                                    <input type="checkbox" name="completed" {{ $item->completed? ' checked ':'' }} />
                                </div>
                            </div>
                        </div>



                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Submit Feedback</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>

        </div>
    </div>
</form>
