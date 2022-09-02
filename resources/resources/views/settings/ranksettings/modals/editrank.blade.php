<div class="modal fade in modal-3d-flip-horizontal modal-info" id="editRankModal" aria-hidden="true" aria-labelledby="editRankModal" role="dialog" tabindex="-1">
      <div class="modal-dialog ">
        <form class="form-horizontal" id="editRankForm"  method="POST">
          <div class="modal-content">
          <div class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="training_title">Edit Rank</h4>
          </div>
            <div class="modal-body">
                <div class="row row-lg col-xs-12">
                  <div class="col-xs-12">
                    @csrf
                      <div class="form-group">
                          <h4 class="example-title">Name</h4>
                          <input type="text" id="editrankname" name="name" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <h4 class="example-title">Grade</h4>
                          <select name="grade_id" id="editrankgrade_id" class="form-control" required>
                              <option value="">Select  Grade</option>
                              @foreach($grades as $grade)
                                  <option value="{{$grade->id}}">{{$grade->level}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="clearfix hidden-sm-down hidden-lg-up"></div>
                </div>
            </div>
            <div class="modal-footer">
              <div class="col-xs-12">

                  <div class="form-group">
                      <input type="hidden" id="cadre_id" name="cadre_id" value="{{$cadre->id}}">
                    <input type="hidden" id="editrank_id" name="rank_id">
                      <input type="hidden" name="type" value="save_rank">
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
