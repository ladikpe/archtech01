



<div id="man-power-approval-module" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-info modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Man-Power Approvals</h4>
            </div>
            <div class="modal-body">

                    <div class="row" id="man-power-approval-module-inner">

                        <table id="tbl" class="table">
                            <tr>
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
                                    Date Approved
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </table>



                    </div>


            </div>
        </div>
    </div>


</div>

<div style="clear: both;">&nbsp;</div>

<div id="update-manpower-approval" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-info modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Approve Stage</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <div class="row">

                        <div class="col-md-12">
                            <label for="">
                                Comments
                            </label>
                            <textarea rows="5"  class="form-control" name="comments" data-input></textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="">
                                Actions
                            </label>
                            <select name="status" data-input id="" class="form-control">
                                <option value="">--Select--</option>
                                <option value="1">Approve</option>
                                <option value="0">Reject</option>
                            </select>
                        </div>

                        {{--<input type="hidden" name="approve" value="1" />--}}


                        <div class="col-md-12" id="group" style="margin-top: 11px;">
                            <label for="">
                            </label>
                            <button id="submit-approval" type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>

                    </div>



                </form>
            </div>
        </div>
    </div>
</div>
