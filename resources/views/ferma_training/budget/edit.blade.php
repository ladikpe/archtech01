<form action="{{ route('call.service',['tr_training_budget:updateTrainingBudget']) }}" method="post">

    @csrf

    <input type="hidden" name="id" value="{{ $item->id }}" />

    <div id="edit-budget{{ $item->id }}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-info modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Training Budget</h4>
                </div>
                <div class="modal-body">


                    <div class="col-md-12">


                        <div class="form-group">
                            <label for="">
                                Year
                            </label>
                            <div style="border: 1px solid #eee;padding: 9px;">
                                {{ $item->year }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">
                                Select Cadre
                            </label>
                            <select data-value="{{ $item->cadre_id }}" name="cadre_id" class="form-control" id="">
                                <option value="">--Select--</option>
                                @foreach ($cadres as $cadre)
                                    <option value="{{ $cadre->id }}">{{ $cadre->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">
                                Total Amount
                            </label>
                            <input type="text" name="total_amount" class="form-control" placeholder="Total Amount" value="{{ $item->total_amount }}" />
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
