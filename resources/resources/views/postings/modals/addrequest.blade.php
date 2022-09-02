<div class="modal fade in modal-3d-flip-horizontal modal-info" id="addPostingModal" aria-hidden="true" aria-labelledby="addPostingModal" role="dialog" >
	    <div class="modal-dialog ">
	      <form class="form-horizontal" id="addPostingForm" enctype="multipart/form-data">
	        <div class="modal-content">
	        <div class="modal-header" >
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title" id="training_title">Create New Posting</h4>
	        </div>
            <div class="modal-body">



            @csrf
             <div class="form-group">
                        <label for="">Employee</label>
                        @php
                            $users=\App\User::where('company_id',companyId())->where('status','!=',2)->get();
                        @endphp
                        <select name="user_id" id="emp" style="width:100%;" class="form-control selecttwo" >
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
             <div class="form-group">
            <label for="">Posting Type</label>
            <select class="form-control" id="abtype" name="posting_type_id"  style="width:100%;" required onchange="checkforupload(this.value);">
              <option value="">-Select Posting Type-</option>

                @foreach($posting_types as $drt)
                <option value="{{$drt->id}}">{{$drt->name}}</option>
                @endforeach


            </select>
            <div class="form-group">
                  <label for="">Location</label>


                    <input type="text" class=" form-control " name="location" placeholder="Location" id="Location" value="" required  />

                </div>
          </div>   
            <div class="form-group">
                  <label for="">Effective Date</label>


                    <input type="text" class=" form-control date_picker" name="effective_date" placeholder="Effective date" id="effective_date" value="" required="" readonly />

                </div>



          


                <div class="form-group">
                    <label for=""> Upload Document</label>
                    <input type="file" class="form-control" name="requested_doc" id="requested_doc">
                </div>


          <div class="form-group">
            <label for="">Comment</label>
            <textarea class="form-control" id="comment" name="comment" style="height: 100px;resize: none;" placeholder="Briefly State Reason" required="required"></textarea>
          </div>

          <input type="hidden" name="type" value="save_posting">

            </div>
            <div class="modal-footer">
              <div class="col-xs-12">

                  <div class="form-group">

                    <button type="submit" class="btn btn-info pull-left">Submit</button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                  </div>
                  <!-- End Example Textarea -->
                </div>
             </div>
	       </div>
	      </form>
	    </div>
	  </div>
