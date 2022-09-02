<div class="pull-right panel-content container-fluid">
  <div class="col-md-12">
   <button type="button" onclick="return false;" class="btn btn-primary" data-toggle="modal" data-target="#attrcreateModuleModal">New AWARD Attribute</button>
 </div>
</div>


<br/>  
<style type="text/css">
  thead tr th{
    color: #fff !important;
  }
</style>








<!---EDIT EXISITING ATTRIBUTTES -->
<div class="modal fade in modal-3d-flip-horizontal modal-primary" id="attreditModuleModal" aria-hidden="true" aria-labelledby="attreditModuleModal"
role="dialog" tabindex="-1">
<div class="modal-dialog ">
  <form class="form-horizontal" id="edit_module_form4" role="form" method="post" action="{{URL('updateattr')}}">
    <div class="modal-content">        
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="training_title">Edit AWARD Attribute</h4>
      </div>
      <div class="modal-body">         

        <div class="col-xs-12">            
          <div class="col-xs-12"> 
            <div class="form-group">
              <input type="hidden" class="form-control" id="attrid" name="id" placeholder="" value="" required />
              <input type="text" autocomplete="off" class="form-control" id="attrname" name="name" placeholder="" value="" required />
            </div> 
            <div class="form-group">
              <label style="font-weight: bold" >Description</label>
              <textarea class="form-control" id="attrdescr" name="descr" rows="5"></textarea>

            </div>


                 <div id="training_name_err"></div>           
               </div>
               <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
             </div>        
           </div>
           <div class="modal-footer">
            <div class="col-xs-12" style="padding-left: 9px;">
              {{ csrf_field() }}
              <input type="hidden" name="awardcategory" value="{{ isset($_GET['awardcategory']) ? $_GET['awardcategory'] : '' }}"/>
              <input type="hidden" name="awardtype" value="{{ isset($_GET['awardtype']) ? $_GET['awardtype'] : ''}}"/>
              <div style="margin-left: 9px;" class="text-xs-left"><span style="margin-right: 10px; class="no-left-padding" id="btn_div"><input type="submit" class="btn btn-primary waves-effect" id="editmodule_btn7" value="Save"></span>

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



















<!---AWARDS ATTRIBUTES-->

<div class="page-content container-fluid">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="panel panel-info panel-line">
        <div class="panel-heading">
          <h3 class="panel-title">AWARDS Category Attributes</h3>

        </div>
        <div class="panel-body">



          <div>
            <form method="GET" id="attribute_filter" action="{{route('attributes')}}">
              <div class="form-group col-md-13">
            <div class="table-responsive">
                <table style="width: 100%">
                  <tr>
                    <th><label>AWARD Category:</label></th>
                    <th><label>AWARD Type :</label></th>
                  </tr>
                  <tr>
                    <td>
                      <select class="form-control" name="awardcategory" id="attrawardcategory" required>
                       <option></option>
                       @foreach($awardcategory as $awardcategoryLoop)
                       <option value="{{ $awardcategoryLoop->id }}" {{isset($_GET['awardcategory']) && $_GET['awardcategory']==$awardcategoryLoop->id ? 'selected' : '' }}>{{ ucwords($awardcategoryLoop->name) }}</option>
                       @endforeach
                     </select>
                   </td>

                   <td>
                    <select class="form-control" name="awardtype" id="attrawardtype" required>
                     <option></option>
                     @foreach($awardtype as $awardtypeLoop)
                     <option value="{{ $awardtypeLoop->id }}" {{isset($_GET['awardtype']) && $_GET['awardtype']==$awardtypeLoop->id ? 'selected' : '' }}>{{ ucwords($awardtypeLoop->name) }}</option>
                     @endforeach
                   </select>
                 </td>
                 <td>
                  <button type="submit" class="btn btn-primary" >Show Attributes</button>
                </td>
              </tr>
            </table> 
</div>
          </div>
        </form>
      </div>



<div class="table-responsive">

      <table class="table table-hover tabletable-striped datatable" id="data_tableUIYU">

        <thead class="bg-blue-600 head">
          <tr>
            <th>S.No</th>
            <th>Attributes</th> 
            <th>AWARD Category</th> 
            <th>AWARD Type</th> 
            <th>Created At</th> 
            @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
            <th>Action</th> 
            @endif
          </tr> 
        </thead> 

        <tbody> 
          @php $sno = 1; @endphp
          @foreach ($attributes as $attributesLoop)                            
          <tr>
           <td>{{ $sno++ }}. </td>                                
           <td data-toggle="tooltip" data-original-title="{{ isset($attributesLoop->descr) ? $attributesLoop->descr : '' }}">{{ isset($attributesLoop->name) ? ucwords($attributesLoop->name) : '' }}</td>

           <td>{{ isset($attributesLoop->award_cat) ? @ucwords( $attributesLoop->Awards($attributesLoop->award_cat) ) : '' }}</td>

           <td>{{ isset($attributesLoop->award_type) ? ucwords( $attributesLoop->AwardType($attributesLoop->award_type) ) : '' }}</td>

           <td> {{ date("F j, Y, g:i a", strtotime($attributesLoop->created_at)) }} </td>

           @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
           <td style="cursor: pointer;">

            <a class="my-btn  btn-sm text-primary" data-create2="{{ $attributesLoop->id }}" data-descr="{{ isset($attributesLoop->descr) ? $attributesLoop->descr : ''  }}" data-value="{{ $attributesLoop->name }}" data-toggle="modal" data-target="#attreditModuleModal">
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>


            <span style="cursor: pointer;">
              <a data-remove2="{{ $attributesLoop->id }}" data-name="{{ $attributesLoop->name }}" class="my-btn text-danger btn-sm"  >
                <i class="fa fa-trash" aria-hidden="true"></i>
              </a>
            </span>
          </td>
          @endif
        </tr>

        @endforeach 


      </tbody>
    </table>
</div>

  </div>



</div>
</div>
</div>

</div>










<!-- CREATE NEW ATTRIBUTE -->
<div class="modal fade in modal-3d-flip-horizontal modal-primary" id="attrcreateModuleModal" aria-hidden="true" aria-labelledby="editModuleModal"
role="dialog" tabindex="-1">
<div class="modal-dialog ">
  <form class="form-horizontal" id="edit_module_form3" role="form" method="post" action="{{URL('updateattr')}}">
    <div class="modal-content">        
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="training_title">Create New Attribute</h4>
      </div>
      <div class="modal-body">         

        <div class="col-xs-12">            
          <div class="col-xs-12"> 
            <div class="form-group">
              <label style="font-weight: bold" >Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="" value="" required list="auto-attribute" spellcheck="off" autocomplete="off" onchange="textrecreate(this.value)"/>
            </div> 
            <div class="form-group">
              <label style="font-weight: bold" >Description</label>
              <textarea class="form-control" id="cdescr" name="cdescr" rows="5"></textarea>

            </div>

                     <!--  <input type="hidden" name="awardcategory" value="{{ isset($_GET['awardcategory']) ? $_GET['awardcategory'] : '' }}"/>
                      <input type="hidden" name="awardtype" value="{{ isset($_GET['awardtype']) ? $_GET['awardtype'] : '' }}"/>
                    -->



                    <div class="form-group">
                      <label style="font-weight: bold">AWARD Category:</label>
                      <select class="form-control" name="awardcategory" id="awardcategory1" required>
                       <option></option>
                       @foreach($awardcategory as $awardcategoryLoop)
                       <option value="{{ $awardcategoryLoop->id }}">{{ ucwords($awardcategoryLoop->name) }}</option>
                       @endforeach
                     </select>
                   </div> 




                   <div class="form-group">
                    <label style="font-weight: bold">AWARD Type:</label>
                    <select class="form-control" name="awardtype" id="awardtype1" required>
                     <option></option>
                     @foreach($awardtype as $awardtypeLoop)
                     <option value="{{ $awardtypeLoop->id }}">{{ ucwords($awardtypeLoop->name) }}</option>
                     @endforeach
                   </select>
                 </div>

                 <div id="training_name_err"></div>           
               </div>
               <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
             </div>        
           </div>
           <div class="modal-footer">
            <div class="col-xs-12">
              {{ csrf_field() }}
              <div style="margin-left: 9px;" class="text-xs-left"><span style="margin-right: 10px; class="no-left-padding" id="btn_div"><input type="submit" class="btn btn-primary waves-effect" id="editmodule_btn6" value="Save"></span>

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



<datalist id="auto-attribute">
  @foreach($attributeslist as $list)
  <option value="{{$list->name}}">
    @endforeach
  </datalist>

  @foreach($attributeslist as $list)
  <p hidden id="{{$list->name}}" style="display: none;">{{ isset($list->descr) ? $list->descr : '' }}</p>
  @endforeach










  <script type="text/javascript">
    $(function(){

      $('#data_tableUIYU').DataTable();

      $('#attribute_filter').submit(function(e){
        e.preventDefault();
        data={
          awardcategory:$('#attrawardcategory').val(),
          awardtype:$('#attrawardtype').val()
        }
        filterAttribute("{{ route('attributes') }}",data,'attributes')
      })
    })

    linkDropDowns('attrawardcategory','attrawardtype');         




    $('[data-create2]').each(function(){

      var $el = $(this);
      var id = $el.data('create2');
      var value = $el.data('value');
      var descr = $el.data('descr');

      $el.on('click',function(){

        $('#attrid').val(id);
        $('#attrname').val(value);
        $('#attrdescr').val(descr);

      });

    });


    $('[data-remove2]').each(function(){
      var $el = $(this);
      var id = $el.data('remove2');
      var name = $el.data('name');

      $el.on('click',function(){
          // return confirm('');
// start
alertify.confirm('Sure you want to delete \'' + name + '\' AWARD Category Attribute?', function(){   
  $.ajax({
    url:"{{url('deletevoteattr')}}",
    type:'get',
    data:{
      id:id
    },
    success:function(data,status){
     if (data == 'success'){
       toastr.success('Category Deleted Successfully');
       reloader();
     }else if (data > 0){
       toastr.error('AWARD Category Attribute Category can\'t be deleted because votes exists');
     }else{
       toastr.error('Something went wrong!!!');
     }
   }
 });

});

});

    });


    function reloader(){
      setTimeout(function(){
        window.location.reload();
      },1000);
    }

  </script>

