@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('Categories Attributes')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('Categories Attributes')}}</li>
    </ol>
    <div class="page-header-actions">
      <div class="row no-space w-250 hidden-sm-down">

        <div class="col-sm-6 col-xs-12">
          <div class="counter">
            <span class="counter-number font-weight-medium">{{date('Y-m-d')}}</span>

          </div>
        </div>
        <div class="col-sm-6 col-xs-12">
          <div class="counter">
            <span class="counter-number font-weight-medium" id="time"></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="page-content container-fluid">
    <div class="row" data-plugin="matchHeight" data-by-row="true">
      <!-- First Row -->


      <!-- End First Row -->
      {{-- second row --}}
      <div class="col-ms-12 col-xs-12 col-md-12">
        <div class="panel panel-info panel-line">

          <div class="panel-body">
            <div class="table-reponsive">




              <style type="text/css">
                .head>tr> th{
                  color: #fff;
                }
                .my-btn.btn-sm {
                  font-size: 0.7.5rem;
                  width: 1.5rem;
                  height: 1.5rem;
                  padding: 0;
                }
                .page-content{
                  padding-top: 0px;
                }
              </style>







              <div class="page-content">

                <div class="panel">

                  <div class="panel-body container-fluid">
                    <div class="row row-lg col-xs-13"> 
                      @if (session('success'))
                      <div class="flash-message">
                        <div class="alert alert-success">
                          {{ session('success') }}
                        </div>
                      </div>
                      @endif
                      @if (session('error'))
                      <div class="flash-message">
                        <div class="alert alert-danger">
                          {{ session('error') }}
                        </div>
                      </div>
                      @endif

                      <div class="col-md-13" style="padding-left: 0px;">



                        <form method="GET" action="{{url('attributes')}}">
                          <div class="form-group col-md-13">
                            <table style="width: 100%">
                              <tr>
                                <th><label>AWARD Category:</label></th>
                                <th><label>AWARD Type :</label></th>
                              </tr>
                              <tr>
                                <td>
                                  <select class="form-control" name="awardcategory" id="awardcategory" required>
                                   <option></option>
                                   @foreach($awardcategory as $awardcategoryLoop)
                                   <option value="{{ $awardcategoryLoop->id }}" {{isset($_GET['awardcategory']) && $_GET['awardcategory']==$awardcategoryLoop->id ? 'selected' : '' }}>{{ ucwords($awardcategoryLoop->name) }}</option>
                                   @endforeach
                                 </select>
                               </td>

                               <td>
                                <select class="form-control" name="awardtype" id="awardtype" required>
                                 <option></option>
                                 @foreach($awardtype as $awardtypeLoop)
                                 <option value="{{ $awardtypeLoop->id }}" {{isset($_GET['awardtype']) && $_GET['awardtype']==$awardtypeLoop->id ? 'selected' : '' }}>{{ ucwords($awardtypeLoop->name) }}</option>
                                 @endforeach
                               </select>
                             </td>
                             <td>
                              <button type="submit" class="btn btn-primary" >Show Attributes</button>
                            </td>


                            <td>
                             <button type="button" onclick="return false;" class="btn btn-primary" style="float: right; margin-bottom: 3px;" data-toggle="modal" data-target="#createModuleModal">Create New Attribute</button>
                           </td>
                         </tr>
                       </table> 

                     </div>
                   </form>






                   <!---EDIT EXISITING ATTRIBUTTES -->
                   <div class="modal fade in modal-3d-flip-horizontal modal-primary" id="editModuleModal" aria-hidden="true" aria-labelledby="editModuleModal"
                   role="dialog" tabindex="-1">
                   <div class="modal-dialog ">
                    <form class="form-horizontal" id="edit_module_form" role="form" method="post" action="{{URL('updateattr')}}">
                      <div class="modal-content">        
                        <div class="modal-header" >
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="training_title">Edit AWARD Attribute</h4>
                        </div>
                        <div class="modal-body">         

                          <div class="col-xs-12">            
                            <div class="col-xs-12"> 
                              <div class="form-group">
                                <input type="hidden" class="form-control" id="id" name="id" placeholder="" value="" required />
                                <input type="text" autocomplete="off" class="form-control" id="name" name="name" placeholder="" value="" required />
                              </div> 
                              <div class="form-group">
                                <label style="font-weight: bold" >Description</label>
                                <textarea class="form-control" id="descr" name="descr" rows="5"></textarea>

                              </div>

                      <div class="form-group"> <!--
          <label style="font-weight: bold">AWARD Type:</label> {{ isset($awardtypeLoop->name) ? ucwords($awardtypeLoop->name) : '' }}<br/>
          <label style="font-weight: bold">AWARD Category:</label> {{ isset($awardtypeLoop->name) ? ucwords($awardcategoryLoop->name) : '' }}

                       <select class="form-control" name="awardcategory" required>
                         <option></option>
                         @foreach($awardcategory as $awardcategoryLoop)
                         <option value="{{ $awardcategoryLoop->id }}" {{isset($_GET['awardcategory']) && $_GET['awardcategory']==$awardcategoryLoop->id ? 'selected' : '' }}>{{ ucwords($awardcategoryLoop->name) }}</option>
                         @endforeach
                       </select>-->
                     </div> 

                     <div class="form-group">



                      <!-- <select class="form-control" name="awardtype" required>
                       <option></option>
                       @foreach($awardtype as $awardtypeLoop)
                       <option value="{{ $awardtypeLoop->id }}" {{isset($_GET['awardtype']) && $_GET['awardtype']==$awardtypeLoop->id ? 'selected' : '' }}>{{ ucwords($awardtypeLoop->name) }}</option>
                       @endforeach
                     </select> -->
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
                <div style="margin-left: 9px;" class="text-xs-left"><span style="margin-right: 10px; class="no-left-padding" id="btn_div"><input type="submit" class="btn btn-primary waves-effect" id="editmodule_btn" value="Save"></span>

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








  <table class="table table-hover dataTable table-striped w-full" id="data_table">
    <thead class="bg-blue-600 head">
      <tr>
        <th>S.No</th>
        <th>Attributes</th> 
        <th>AWARD Category</th> 
        <th>AWARD Type</th> 
        <th>Created At</th> 
        @if(Auth::user()->role==Config::get('constants.roles.Admin_User'))
        <th colspan="2">Action</th> 
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


       <td><span style="cursor: pointer;"><a class="my-btn  btn-sm text-primary" data-create="{{ $attributesLoop->id }}" data-descr="{{ isset($attributesLoop->descr) ? $attributesLoop->descr : ''  }}" data-value="{{ $attributesLoop->name }}" data-toggle="modal" data-target="#editModuleModal"><i class="icon wb-pencil" aria-hidden="true"></i></a></span></td>

       <td>     <span style="cursor: pointer;"><a data-remove="{{ $attributesLoop->id }}" data-name="{{ $attributesLoop->name }}" class="my-btn text-danger btn-sm"  ><i class="icon wb-trash" aria-hidden="true"></i></a></span></td>



       @endforeach 

     </tr>
   </tbody>
 </table>


 @if(count($attributes) < 1)
 <div class="flash-message">
  <div class="alert alert-warning">
   No Attribute have been set for this AWARD Category
 </div>
</div>
@endif





</div>
</div>

</div>
</div>


</div>













<!-- CREATE NEW ATTRIBUTE -->
<div class="modal fade in modal-3d-flip-horizontal modal-primary" id="createModuleModal" aria-hidden="true" aria-labelledby="editModuleModal"
role="dialog" tabindex="-1">
<div class="modal-dialog ">
  <form class="form-horizontal" id="edit_module_form" role="form" method="post" action="{{URL('updateattr')}}">
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

            <input type="hidden" name="awardcategory" value="{{ isset($_GET['awardcategory']) ? $_GET['awardcategory'] : '' }}"/>
            <input type="hidden" name="awardtype" value="{{ isset($_GET['awardtype']) ? $_GET['awardtype'] : '' }}"/>



            <div id="training_name_err"></div>           
          </div>
          <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
        </div>        
      </div>
      <div class="modal-footer">
        <div class="col-xs-12">
          {{ csrf_field() }}
          <div style="margin-left: 9px;" class="text-xs-left"><span style="margin-right: 10px; class="no-left-padding" id="btn_div"><input type="submit" class="btn btn-primary waves-effect" id="editmodule_btn" value="Save"></span>

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
    (function($){
      $(function(){

     // start
     $('[data-remove]').each(function(){
      var $el = $(this);
      var id = $el.data('remove');
      var name = $el.data('name');

      $el.on('click',function(){
          // return confirm('');
// start
alertify.confirm('Sure you want to delete \'' + name + '\' category?', function(){   
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
       toastr.error('Vote Category can\'t be deleted because votes exists');
     }else{
       toastr.error('Something went wrong!!!');
     }
   }
 });

});

});

    });
      // end


      function reloader(){
        setTimeout(function(){
          window.location.reload();
        },1000);
      }


      $('[data-create]').each(function(){

        var $el = $(this);
        var id = $el.data('create');
        var value = $el.data('value');
        var descr = $el.data('descr');

        $el.on('click',function(){

          $('#id').val(id);
          $('#name').val(value);
          $('#descr').val(descr);
          
        });

      });
// end ...


});
    })(jQuery); 




  </script>




  <script type="text/javascript">
   (function($){
    $(function(){


     var listeners = {};

     function attach(tag,cb){
       listeners[tag] = listeners[tag] || [];
       listeners[tag].push(cb);
     }

     function notify(tag,data){
      if (listeners[tag]){
        listeners[tag].forEach(function(v,k){
          v(data);
        });
      }
    }



    function linkDropDowns($first,$second){

       var $awardcategory = $('#' + $first); //'#awardcategory'
       var $awardtype = $('#' + $second); //'#awardtype'

       attach('award-changed',function(data){
        data = data.toLowerCase();

        if (data.split(' ').indexOf('department') != -1 || data.split(' ').indexOf('unit') != -1 || data.split(' ').indexOf('zone of') != -1 || data.split(' ').indexOf('office') != -1){
         $awardtype.val(2);
       }else{
         $awardtype.val(1);
       }

     }); 

       $awardcategory.on('change',function(){
        // alert('okkkk');
        //option:selected").text()
        notify('award-changed',$('#' + $first + ' option:selected').text());
      });

     }


     linkDropDowns('awardcategory','awardtype');

        //linkDropDowns('awardcategory1','awardtype1');



      });
  })(jQuery);





  function textrecreate(args){
    document.getElementById('cdescr').value = 
    document.getElementById(args).innerHTML;
  }


</script>













</div> 


</div>
</div>

</div>

</div>
</div>
</div>
<!-- End Page -->

@endsection
@section('scripts')
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
<script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
   $('#award-table').DataTable()

 });

</script>
@endsection