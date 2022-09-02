<div class="modal fade in modal-3d-flip-horizontal modal-info" id="uploadEmeasuresModal" aria-hidden="true" aria-labelledby="uploadEmeasuresModal" role="dialog" tabindex="-1">
	    <div class="modal-dialog ">
	      <form class="form-horizontal" id="uploadEmeasuresForm" enctype="multipart/form-data" >
	        <div class="modal-content">        
	        <div class="modal-header" >
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title" id="training_title">Upload Department Evaluation Template</h4>
	        </div>
            <div class="modal-body">         
                
                  	
            
            @csrf
            <a href="{{url('bscsettings/download_template')}}">Download Template for upload</a>
          <div class="form-group">
            <label for="">Template</label>
            <input type="file" name="template" class="form-control" required>
          </div>
          <input type="hidden" name="type" value="import_emeasures">
           <input type="hidden" name="evaluation_id" value="{{$evaluation->id}}">
          
            </div>
            <div class="modal-footer">
              <div class="col-xs-12">
              
                  <div class="form-group">
                    
                    <button type="submit" class="btn btn-info pull-left">Upload</button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                  </div>
                  <!-- End Example Textarea -->
                </div>
             </div>
	       </div>
	      </form>
	    </div>
	  </div>