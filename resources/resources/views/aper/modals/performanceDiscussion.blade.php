<div class="modal fade" id="performanceDiscussion" aria-labelledby="examplePositionSidebar" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog modal-simple modal-sidebar modal-lg">
                            <div class="modal-content" style="margin-top: -1%">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Performance Discussion</h4>
                              </div>
                              <div class="modal-body">
                                  <div id="performanceDiscussionAjax">
                                  </div>

                                  <div id="addDiscussion">

                                  <hr>
                                  <div class="col-md-12">
                                  <h4> <strong>Enter Performance Discussion Below : </strong><br><br></h4>
                                  Title: <br>
                                  <input placeholde="Enter Discussion Title" type="text" class="form form-control" id="Disctitle"><br>
                                 Discussion: <br>
                                  <textarea id="perfromanceDiscussionText" class="summernote"></textarea><br>

                                   <button type="button" onclick="savePerformance({{$evaluation->id}})" style="width:150px" class="btn btn-primary btn-block">Save</button>

                                   <div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button> -->
                              </div>
                            </div>

                          </div>
                        </div>

