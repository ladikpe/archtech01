<!-- <div class="pull-right panel-content container-fluid">
  <div class="col-md-12">
    @if($voteswitch == '1')
    <a href="/=SW5kaXZpZHVhbCBBV0FSRA==/0" class="btn btn-danger">Disable Voting</a>
    @else
    <a href="/=SW5kaXZpZHVhbCBBV0FSRA==/1" class="btn btn-primary">Enable Voting</a>
    @endif

    <button type="button" style="margin-left: 10px;" class="btn btn-primary" data-toggle="modal" data-target="#createModuleModal">New AWARD Category</button>
  </div>
</div>


<br/>  -->
<style type="text/css">
  thead tr th{
    color: #fff !important;
  }
</style>


<!---INDIVIDUAL AWARDS -->

<div class="page-content container-fluid">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="panel panel-info panel-line">
        <div class="panel-heading">
          <h3 class="panel-title">Individual AWARDs</h3>

        </div>
        <div class="panel-body">




<div class="table-responsive">
          <table id="exampleTablePagination" data-toggle="table"
          data-query-params="queryParams" data-mobile-responsive="true"
          data-height="400" data-pagination="true" data-search="true" class="table table-striped">
          <thead class="bg-blue-600 head">
            <tr>
              <th>S.No</th>
              <th>Category Name</th>
              <th>AWARD Type</th>
              <th>Eligible Voter(s)</th>
              <th>Created At</th>
                @if(\Auth::user()->role->permissions->contains('constant', 'configure_vote'))
              <th colspan="3">Action</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @php $sno = 1; @endphp
            @foreach ($awards as $award)
            <tr id="tr{{ $award->id }}">
              <td>{{$sno++}}. </td>
              <td>{{ ucwords($award->name) }}</td>

              <td> {{ $award->AWARDType($award->award_type)->name }}  </td>




              <td> {{ $award->AWARDEligibilityCount($award->id) }}  </td>

              <td> {{ date("F j, Y, g:i a", strtotime($award->created_at)) }} </td>


             @if(\Auth::user()->role->permissions->contains('constant', 'configure_vote'))
              <td>
                <span style="cursor: pointer;"><a onclick="loadEligibleVoters($(this).attr('href')); return false;" href="eligiblevotersmodal?ac={{$award->id}}&opt=1&&dd={{ base64_encode($award->name) }}" class="my-btn btn-sm text-primary" data-toggle="tooltip" data-original-title="Eligible Voters"><i class="fa fa-users" aria-hidden="true"></i></a></span>
              </td>


              <td><span style="cursor: pointer;"><a class="my-btn  btn-sm text-primary" data-create="{{ $award->id }}" data-value="{{ $award->name }}" data-toggle="modal" data-target="#editModuleModal"><i class="fa fa-pencil" aria-hidden="true"  data-toggle="tooltip" data-original-title="Edit Individual AWARD"></i></a></span></td>

              <td>     <span style="cursor: pointer;"><a data-id="{{ $award->id }}" data-remove="{{ $award->id }}" data-name="{{ $award->name }}" class="my-btn text-danger btn-sm"  data-toggle="tooltip" data-original-title="Delete Individual AWARD" ><i class="fa fa-trash" aria-hidden="true"></i></a></span></td>

              @endif

              @endforeach

            </tr>
          </tbody>
        </table>
</div>

      </div>



    </div>
  </div>
</div>

</div>












<!---TEAMS AWARDS -->
<div class="page-content container-fluid">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="panel panel-info panel-line">
        <div class="panel-heading">
          <h3 class="panel-title">Team AWARDs</h3>

        </div>
        <div class="panel-body">




<div class="table-responsive">
          <table id="exampleTablePagination" data-toggle="table"
          data-query-params="queryParams" data-mobile-responsive="true"
          data-height="400" data-pagination="true" data-search="true" class="table table-striped">
          <thead class="bg-blue-600 head">
            <tr>
              <th>S.No</th>
              <th>Category Name</th>
              <th>AWARD Type</th>
              <th>Eligible Voter(s)</th>
              <th>Created At</th>
             @if(\Auth::user()->role->permissions->contains('constant', 'configure_vote'))
              <th colspan="3">Action</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @php $sno = 1; @endphp
            @foreach ($awards2 as $award)
            <tr id="tr{{ $award->id }}">
              <td>{{$sno++}}. </td>
              <td>{{ ucwords($award->name) }}</td>

              <td> {{ $award->AWARDType($award->award_type)->name }}  </td>

              <td>{{ $award->AWARDEligibilityCount($award->id) }}</td>

              <td> {{ date("F j, Y, g:i a", strtotime($award->created_at)) }} </td>



             @if(\Auth::user()->role->permissions->contains('constant', 'configure_vote'))
              <td><span style="cursor: pointer;"><a onclick="loadEligibleVoters($(this).attr('href')); return false;" href="eligiblevotersmodal?ac={{$award->id}}&opt=1&&dd={{ base64_encode($award->name) }}" class="my-btn btn-sm text-primary" data-toggle="tooltip" data-original-title="Eligible Voters"><i class="fa fa-users" aria-hidden="true"></i></a></span></td>


              <td><span style="cursor: pointer;"><a class="my-btn  btn-sm text-primary" data-create="{{ $award->id }}" data-value="{{ $award->name }}" data-toggle="modal" data-target="#editModuleModal"><i class="fa fa-pencil" aria-hidden="true"  data-toggle="tooltip" data-original-title="Edit Team AWARD"></i></a></span></td>

              <td>     <span style="cursor: pointer;"><a data-id="{{ $award->id }}" data-remove="{{ $award->id }}" data-name="{{ $award->name }}" class="my-btn text-danger btn-sm"  data-toggle="tooltip" data-original-title="Delete Team AWARD"><i class="fa fa-trash" aria-hidden="true"></i></a></span></td>
              @endif

              @endforeach

            </tr>
          </tbody>
        </table>
</div>

      </div>



    </div>
  </div>
</div>

</div>









<!---MERTIT AWARDS -->
<div class="page-content container-fluid">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="panel panel-info panel-line">
        <div class="panel-heading">
          <h3 class="panel-title">Merit AWARDs</h3>

        </div>
        <div class="panel-body">




<div class="table-responsive">
          <table id="exampleTablePagination" data-toggle="table"
          data-query-params="queryParams" data-mobile-responsive="true"
          data-height="400" data-pagination="true" data-search="true" class="table table-striped">
          <thead class="bg-blue-600 head">
            <tr>
              <th>S.No</th>
              <th>Category Name</th>
              <th>AWARD Type</th>
              <th>Created At</th>
             @if(\Auth::user()->role->permissions->contains('constant', 'configure_vote'))
              <th colspan="2">Action</th>
              @endif
            </tr>
          </thead>


          <tbody>
            @php $sno = 1; @endphp
            @foreach ($awards3 as $award)
            <tr id="tr{{ $award->id }}">
              <td>{{$sno++}}. </td>
              <td>{{ ucwords($award->name) }}</td>

              <td> {{ $award->AWARDType($award->award_type)->name }}  </td>

              <td> {{ date("F j, Y, g:i a", strtotime($award->created_at)) }} </td>

             @if(\Auth::user()->role->permissions->contains('constant', 'configure_vote'))
              <td><span style="cursor: pointer;"><a class="my-btn  btn-sm text-primary" data-create="{{ $award->id }}" data-value="{{ $award->name }}" data-toggle="modal" data-target="#editModuleModal"><i class="fa fa-pencil" aria-hidden="true"  data-toggle="tooltip" data-original-title="Edit Merit AWARD"></i></a></span></td>

              <td>     <span style="cursor: pointer;"><a data-id="{{ $award->id }}" data-remove="{{ $award->id }}" data-name="{{ $award->name }}" class="my-btn text-danger btn-sm"  data-toggle="tooltip" data-original-title="Delete Merit AWARD"><i class="fa fa-trash" aria-hidden="true"></i></a></span></td>
              @endif
              @endforeach

            </tr>
          </tbody>
        </table>
</div>

      </div>



    </div>
  </div>
</div>

</div>




<script type="text/javascript">

  function loadEligibleVoters(href){
    data={}
    $('#votesettingsModalTitle').text('Eligible Voters');
    filterAttribute(href,data,'votesettingsModalBody')
    $('#votesettingsModal').modal('show');
  }
</script>






<!--- edit module -->
<div class="modal fade in modal-3d-flip-horizontal modal-primary" id="editModuleModal" aria-hidden="true" aria-labelledby="editModuleModal"
role="dialog" tabindex="-1">

<div class="modal-dialog ">

  <form class="form-horizontal" id="edit_module_form" role="form" method="post" action="{{ route('createaward') }}">

    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="training_title">Edit AWARD Category Name</h4>
      </div>
      <div class="modal-body">

        <div class="col-xs-12">
          <div class="col-xs-12">
            <div class="form-group">
              <input type="hidden" class="form-control" id="id" name="id" placeholder="" value="" required />
              <label>Category Name:</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="" value="" style="" autocomplete="off" required />
            </div>
          </div>
          <div class="clearfix hidden-sm-down hidden-lg-up"></div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-xs-12">
          {{ csrf_field() }}
          <div style="margin-left: 9px;" class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="submit" style="margin-right: 10px;" class="btn btn-primary waves-effect" id="editmodule_btn0" value="Save"></span>

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
<!-- edit module modal end -->




<!--- create module -->
<div class="modal fade in modal-3d-flip-horizontal modal-primary" id="createModuleModal" aria-hidden="true" aria-labelledby="createModuleModal"
role="dialog" tabindex="-1">

<div class="modal-dialog ">

  <form class="form-horizontal" id="create_module_form" role="form" method="post" action="cawards">

    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="training_title">Create New AWARD Category</h4>
      </div>
      <div class="modal-body">

        <div class="col-xs-12">
          <div class="col-xs-12">
            <div class="form-group">
              <label style="font-weight: bold;">Category Name:</label>
              <input type="text" autocomplete="off" class="form-control" name="name" placeholder="" value="" style="" required />
            </div>

            <div class="form-group">
              <label style="font-weight: bold;">AWARD Type:</label>
              <select class="form-control" name="awardtype" id="awardtype" required>
               <option></option>
               @foreach($awardtype as $awardtypeLoop)
               <option value="{{ $awardtypeLoop->id }}" {{isset($_GET['awardtype']) && $_GET['awardtype']==$awardtypeLoop->id ? 'selected' : '' }}>{{ ucwords($awardtypeLoop->name) }}</option>
               @endforeach
             </select>
           </div>
           <input type="hidden" class="form-control"  name="id" placeholder="" value="" required />


         </div>
         <div class="clearfix hidden-sm-down hidden-lg-up"></div>
       </div>
     </div>
     <div class="modal-footer">
      <div class="col-xs-12">
        {{ csrf_field() }}
        <div style="margin-left: 9px;" class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="submit" style="margin-right: 10px;" class="btn btn-primary waves-effect" id="editmodule_btn1" value="Save"></span>

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




                 (function($){
                  $(function(){

     // start
     $('[data-remove]').each(function(){
      var $el = $(this);
      var id = $el.data('remove');
      var name = $el.data('name');
      var $dataId = $el.data('id');
      var $trId = $('#tr' + $dataId);

      $el.on('click',function(){
// start
alertify.confirm('Sure you want to delete \'' + name + '\' AWARD Category?', function(){
  $.ajax({
    url:"{{url('deletevoteaward')}}",
    type:'get',
    data:{
      id:id
    },
    success:function(data,status){
     if (data == 'success'){
       toastr.success('Category Deleted Successfully');
           // reloader();
           $trId.remove();
         }else if (data > 0){
           toastr.error('AWARD Category can\'t be deleted because votes exists');
           // reloader();
         }else{
           toastr.error('Something went wrong!!!');
           // reloader();
         }
       }
     });

});
// stop

     // start
// stop


});

    });
      // end


      function reloader(){
        setTimeout(function(){
          window.location.reload();
        },1000);
      }



      $('[data-create]').each(function(){
        // alert(22);
        //exit;
        var $el = $(this);
        var id = $el.data('create');
        var value = $el.data('value');

        $el.on('click',function(){

          $('#id').val(id);
          $('#name').val(value);

        });

      });
// end ...





});
                })(jQuery);

</script>
