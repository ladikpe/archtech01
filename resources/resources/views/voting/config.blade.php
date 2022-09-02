 
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('Attributes Configuration')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('Attributes Configuration')}}</li>
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
  tr, th{
    color: #fff !important;
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
            



            <div class="form-group" class="col-md-12">
              <table style="width: 100%">
                <form method="GET" action="{{url('config')}}">
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
                </form>
                </td>

              </tr>
            </table> 
          </div>
          
          <div class="col-md-13">


            



           <table class="table table-hover tabletable-striped dataTable" id="award-table" >
      <thead class="bg-blue-600 head">             
              <tr>
                <th>S/N</th>
                @foreach($votelists as $votelist) 
                <th>
                  {{ ucwords($votelist->name) }}
                </th>
                @endforeach
                <!-- <th> Lock Score </th> -->
                <th style="font-weight: bold !important; color: #d00 !important;">Priority vector</th>
                <th>Action</th>
              </tr>
            </thead> 
            <tbody>

             @if(count($votelists) > 0 )
             @php $sn = 1 @endphp
             
             <tr>
              <form method="POST" action="{{url('config')}}">
                {{ csrf_field() }}
                <td> {{ $sn }}. </td>
                
                @php $sn++;
                $total = 0; 
                $totallimit = (9 * count($votelists));
                @endphp

          
                @foreach($votelists as $k1=>$votelist) 
                <td class="cls">
                  <input data-model="" name="value[{{ $votelist->id }}]" type="text" style="width: 70px;" class="form-control" maxlength="3" min="1" max="9" autocomplete="off"value="{{ $votelist->votePercentage() }}" />
                </td>
                @endforeach

              </td>
              <input type="hidden" name="award_cat" value="{{ $votelist->award_cat }}"/>
              <input type="hidden" name="award_type" value="{{ $votelist->award_type }}"/>


             <!-- <td><input type="text" value="10" style="width: 70px;" class="form-control" readonly></td> -->

              <td>
                <input id="total" type="text" style="width: 70px;" value="{{  $total }}" class="form-control" maxlength="3" readonly/>
              </td>
              <td>
                <button id="save" type="submit" class="btn btn-primary">Save </button>
              </td>
            </form>

          </tr>
        </tbody>
      </table>

      @else
    </table>
      @endif

    </div>
  </div>          

</div>
</div>





</div>

</div>




<script>
 
 (function($){

  function calRows($parent,$total,$save){
    var total = 0;
    $parent.find('input').each(function(){
      total+=(+$(this).val());
    });

    $total.val(total/* + 10*/);

    checkSaveAction(total,$save);
    // alert(total);
  }


  function checkSaveAction(val,$obj){
    if ((val/* + 10*/) > 100){
     $obj.attr('disabled','disabled');
       //$obj.css('color','red');
     }else{
       $obj.removeAttr('disabled');
       //$obj.css('color','green');
     }
   }

   $(function(){


    $("[data-model]").each(function(id, el){

      var $obj = $(this);
      var vl = $obj.data('model');
      var $parentGroup = $('.cls' + vl);
      var $total = $('#total' + vl);
      var $save = $('#save' + vl);
      
    // alert('123');
    
    $obj.on('keyup',function(){
     calRows($parentGroup,$total,$save);     
   });
    $obj.trigger('keyup');

// sum += $(el).val();

// alert( cadre );

});




  });
 })(jQuery);


// function calcTotal (cadre) {
//   var sum = 0;

// }



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

                 linkDropDowns('awardcategory1','awardtype1');
                 


               });
})(jQuery);

</script>

















            </div> 


          </div>
        </div>

      </div>

    </div>
  </div>
</div>
<!-- End Page -->

 
<!-- <script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
  <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{ asset('global/vendor/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script> -->
  <script type="text/javascript">
      $(document).ready(function() {
 $('#award-table').DataTable()

      });
      
  </script>
 