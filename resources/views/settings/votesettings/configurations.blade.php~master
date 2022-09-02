 
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
                  <h3 class="panel-title">AWARDS Attributes Configurations</h3>

                  </div>
                <div class="panel-body">
        

<div class="table-responsive">
            <div class="form-group" class="col-md-12">
              <table style="width: 100%">
                <form  >
                  <tr>
                    <th><label>AWARD Category:</label></th>
                    <th><label>AWARD Type :</label></th>
                  </tr>
                  <tr>
                    <td>
                      <select class="form-control" name="awardcategory" id="awardcategory_attributeconfig" required>
                       <option></option>
                       @foreach($awardcategory as $awardcategoryLoop)
                       <option value="{{ $awardcategoryLoop->id }}" {{isset($_GET['awardcategory']) && $_GET['awardcategory']==$awardcategoryLoop->id ? 'selected' : '' }}>{{ ucwords($awardcategoryLoop->name) }}</option>
                       @endforeach
                     </select>
                   </td>

                   <td>
                    <select class="form-control" name="awardtype" id="awardtype_attributeconfig" required>
                     <option></option>
                     @foreach($awardtype as $awardtypeLoop)
                     <option value="{{ $awardtypeLoop->id }}" {{isset($_GET['awardtype']) && $_GET['awardtype']==$awardtypeLoop->id ? 'selected' : '' }}>{{ ucwords($awardtypeLoop->name) }}</option>
                     @endforeach
                   </select>
                 </td>
                 <td>
                  <button  onclick="filterAwardAttribute()" class="btn btn-primary" >Show Attributes</button>
                </form>
                </td>

              </tr>
            </table> 
          </div>
</div>




<div class="table-responsive">
       <form  id="config_submit">
  <table id="exampleTablePagination" data-toggle="table" 
                      data-query-params="queryParams" data-mobile-responsive="true"
                      data-height="400" data-pagination="true" data-search="true" class="table table-striped">
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
       
                {{ csrf_field() }}
                <td> {{ $sn }}. </td>    
                @php $sn++;
                $total = 0; 
                $totallimit = (9 * count($votelists));
                @endphp
          
                @foreach($votelists as $k1=>$votelist) 
                <td class="cls">
                  <input type="hidden" value="{{$votelist->id}}" class="vot_cat_id">
                  <input data-model=""  type="text" style="width: 70px;" class="form-control vote_config_number" maxlength="3" min="1" max="9" autocomplete="off"value="{{ $votelist->votePercentage() }}" />
                </td>
                @endforeach

              </td>
              <input type="hidden" id="award_cat" value="{{ $votelist->award_cat }}"/>
              <input type="hidden" id="award_type" value="{{ $votelist->award_type }}"/>
              <td>
                <input id="total" type="text" style="width: 70px;" value="{{  $total }}" class="form-control" maxlength="3" readonly/>
              </td>
              <td>
                <button id="save"  type="submit"  class="btn btn-primary">Save </button>
              </td>
          
          </tr>
        </tbody>
            </table>
</div>

      @endif
  </form>
                </div>

                

              </div>
            </div>
        </div>

    </div>






<script type="text/javascript">
  function filterAwardAttribute(){
     data={
    awardcategory:$('#awardcategory_attributeconfig').val(),
    awardtype:$('#awardtype_attributeconfig').val()
  }
  filterAttribute("{{ route('configurations') }}",data,'configurations');
  }



linkDropDowns('awardcategory_attributeconfig','awardtype_attributeconfig');         
                 


 



</script>


<script>
 (function($){

 
      $('#config_submit').submit(function(event){

          event.preventDefault();
          
          config=$('.vote_config_number').map(function(index,value){
              return value.value
          }).get();

           vot_cat_id=$('.vot_cat_id').map(function(index,value){
              return value.value
          }).get();
           
            data={
              value:config ,
              vot_cat_id:vot_cat_id,
              award_cat:document.querySelector('#award_cat').value,
              award_type:document.querySelector('#award_type').value,
              _token:'{{csrf_token()}}'
            }
            fetch(`{{url('configset')}}?award_type=${data.award_type}&award_cat=${data.award_cat}&config=${data.value}&vot_cat_id=${data.vot_cat_id}`).then((response)=>response.json())
              .then((data_elem)=>{

                  if(data_elem.status=='success'){
                      toastr.success(data_elem.message);
                  }
              })
          
          

      });


  function calRows($parent,$total,$save){
    var total = 0;
    document.querySelectorAll('.vote_config_number').forEach((elem)=>{
        total +=parseFloat(elem.value) 
    })

    $total.val(isNaN(total) ? 0: total);

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





