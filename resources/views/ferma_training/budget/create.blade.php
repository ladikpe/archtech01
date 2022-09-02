<form action="{{ route('call.service',['tr_training_budget:createTrainingBudget']) }}" method="post" enctype="multipart/form-data" >

    @csrf

<div id="create-budget" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Training Budget</h4>
            </div>
            <div class="modal-body">


                <div class="col-md-12">


                    <div class="form-group">
                        <label for="">
                            Year
                        </label>
                        <div style="border: 1px solid #eee;padding: 9px;">
                            {{ date('Y') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">
                            Select Cadre
                        </label>
                        <select name="cadre_id" class="form-control" id="">
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
                        <input type="text" name="total_amount" class="form-control" placeholder="Total Amount" />
                    </div>


                    <div class="form-group">
                        <label for="">
                            Import Excel File
                        </label>
                        <input type="file" name="excel" class="form-control" placeholder="Excel File." />
                    </div>

                    <div class="form-group">
                        <label for="">
                            Download Excel Template
                        </label>
                        <a href="{{ asset('excel_template_budget.xlsx') }}">Download Template</a>
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
