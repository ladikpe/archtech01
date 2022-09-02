{{--data-create-manpower--}}
<div id="create-manpower" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-info modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Man-Power</h4>
            </div>
            <div class="modal-body">
                <form data-create-manpower-form js action="{{ route('man_power_training.store') }}" method="post">


                    <div class="row">

                        <div class="col-md-6">
                            <label for="">
                                Name Of Institution
                            </label>
                            <input type="text" data-input name="name_of_institution" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label for="">
                                Date Of Training
                            </label>
                            <input type="date" data-input name="date_of_training" class="form-control" />
                        </div>


                        <div class="col-md-6">
                            <label for="">
                                Cost Of Study
                            </label>
                            <input type="text" data-input name="total_cost_of_training" class="form-control" />
                        </div>


                        <div class="col-md-6">
                            <label for="">
                                Study Type
                            </label>
                            <select name="study_type" class="form-control" data-input id="study_type">
                                <option value="">--Select--</option>
                                <option value="parttime">Part-Time</option>
                                <option value="fulltime">Full-Time</option>
                            </select>
                        </div>



                        <div class="col-md-12">
                            <label for="">
                                Staff To Be Enrolled
                            </label>
                            <select data-input data-users url="{{ route('man_power_training.show',['fetch-users']) }}"
                                    key="id"
                                    label="name"
                                    name="user_id" class="form-control" js js-data-select>
                                <option value="">--Select--</option>
                            </select>
                        </div>




                        <div class="col-md-6" id="withpay" style="margin-top: 11px;">
                            <label for="">
                                With Pay
                            </label>
                            <input data-input type="checkbox" name="study_leave_with_pay" value="1" />
                        </div>


                        <div class="col-md-12" id="group" style="margin-top: 11px;">
                            <label for="">
                            </label>
                            <button type="submit" class="btn btn-sm btn-success">Create</button>
                        </div>

                    </div>



                </form>
            </div>
        </div>
    </div>
</div>

<div id="update-manpower" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-info modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update Man-Power</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('man_power_training.store') }}" method="post">

                    <div class="row">

                        <div class="col-md-6">
                            <label for="">
                                Name Of Institution
                            </label>
                            <input type="text" data-input name="name_of_institution" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label for="">
                                Date Of Training
                            </label>
                            <input type="date" data-input name="date_of_training" class="form-control" />
                        </div>


                        <div class="col-md-6">
                            <label for="">
                                Cost Of Study
                            </label>
                            <input type="text" data-input name="total_cost_of_training" class="form-control" />
                        </div>


                        <div class="col-md-6">
                            <label for="">
                                Study Type
                            </label>
                            <select name="study_type" class="form-control" data-input id="study_type">
                                <option value="">--Select--</option>
                                <option value="parttime">Part-Time</option>
                                <option value="fulltime">Full-Time</option>
                            </select>
                        </div>



                        <div class="col-md-12">
                            <label for="">
                                Staff To Be Enrolled
                            </label>
                            <select data-input data-users name="user_id" class="form-control">
                                <option value="">--Select--</option>
                            </select>
                        </div>




                        <div class="col-md-6" id="withpay" style="margin-top: 11px;">
                            <label for="">
                                With Pay
                            </label>
                            <input data-input type="checkbox" name="study_leave_with_pay" value="1" />
                        </div>


                        <div class="col-md-12" id="group" style="margin-top: 11px;">
                            <label for="">
                            </label>
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12" style="margin-top: 16px;margin-bottom: 11px;">
                            Approval History
                        </div>

                        <div class="col-md-12" id="approval-outlet"></div>

                    </div>



                </form>
            </div>
        </div>
    </div>
</div>



<div id="man-power-module">

    <div class="col-md-12" align="right" style="margin-bottom: 11px;">
        <button class="btn btn-sm btn-primary" data-create-form>
            + Request Man-Power
        </button>
    </div>

    <table id="tbl" class="table">
        <tr>
            <th>
                Name Of Institution
            </th>
            <th>
                Cost Of Study
            </th>
            <th>
                Study Type
            </th>
            <th>
                Date Of Training
            </th>
            <th>
                Status
            </th>
            <th>
                Actions
            </th>
        </tr>
    </table>

</div>
