<div class="pull-right panel-content container-fluid">
  <div class="col-md-12">
    @if($voteswitch == '1')
          <button onclick="filterAttribute('/=SW5kaXZpZHVhbCBBV0FSRA==/0','','awardsyear')" class="btn btn-danger">Disable Voting</button>
    @else
      <button onclick="filterAttribute('/=SW5kaXZpZHVhbCBBV0FSRA==/1','','awardsyear')" class="btn btn-success">Enable Voting</button>
    @endif

    <button type="button" style="margin-left: 10px;" class="btn btn-primary" data-toggle="modal" data-target="#createModuleModal">New AWARD</button>

    <button type="button" style="margin-left: 10px;" class="btn btn-primary" data-toggle="modal" data-target="#createYearModal">New Year</button>
  </div>
</div>


<br/> 


<style type="text/css">
  thead tr th{
    color: #fff !important;
  }
</style>


<!---AWARDS ATTRIBUTES-->

      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="panel panel-info panel-line">
                <div class="panel-heading">
                  <h3 class="panel-title">AWARDS Years</h3>

                  </div>
                <div class="panel-body">
        


                  <form method="POST" id="select_vote_year" action="{{url('selectyear')}}">
                {{ csrf_field() }}
                    <div class="form-group">
                      <select class="form-control" name="year" id="award_year_"  >
                        @forelse($awardyears as $award)
                        <option  class="col-md-6" value="{{$award->year}}" {{$award->status == 1 ? 'selected':''}}> {{$award->status == 1 ? 'Active Year::':''}} {{$award->year}}</option>
                        @empty
                        <option value="0">Please Create an AWARD year</option>
                        @endforelse
                        
                      </select>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-info" >Activate AWARD Year</button>
                    </div>
                  </form>




                </div>

                

              </div>
            </div>
        </div>

    </div>










<!--- create module -->
<div class="modal fade in modal-3d-flip-horizontal modal-primary" id="createYearModal" aria-hidden="true" aria-labelledby="createModuleModal"
role="dialog" tabindex="-1">

<div class="modal-dialog ">

  <form class="form-horizontal" id="awardsyear" role="form" method="post" action="{{ url('cawardsyear') }}">

    <div class="modal-content">        
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="training_title">Create New AWARD Year</h4>
      </div>
      <div class="modal-body">         

        <div class="col-xs-12">            
          <div class="col-xs-12"> 
            <div class="form-group">
              <label style="font-weight: bold;">Year:</label>
              <input type="text" maxlength="4" autocomplete="off" class="form-control" id="year" name="year" placeholder="" value="" style="" required />
            </div>   

         </div>
         <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
       </div>        
     </div>
     <div class="modal-footer">
      <div class="col-xs-12">
        {{ csrf_field() }}
        <div style="margin-left: 9px;" class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="submit" style="margin-right: 10px;" class="btn btn-primary waves-effect" id="editmodule_btn5" value="Save"></span>

          <span class="no-left-padding"><input type="button" class="btn btn-default waves-effect" value="Cancel"  data-dismiss="modal"></span>
        </div>
      </div>
      <!-- End Example Textarea -->
    </div>
  </div>
</form>
</div>

</div>
</div>
<!-- Add module modal end -->



<script type="text/javascript">
$(function(){
  
  $('#select_vote_year').submit(function(){
    event.preventDefault();
     award_year=document.querySelector('#award_year_').value;
     fetch('{{url('selectyear')}}?award_year='+award_year,{
        method:'GET',
       }).then((response)=>response.json()).then((data_success)=>{
        if(data_success.status==='success'){
        toastr.success(data_success.message)
              $("#ldr").load('{{url('allvotesettings')}}');
        }
     })

  })






  
  })
</script>