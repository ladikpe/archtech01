<style type="text/css">
  .head>tr> th{
    color: #fff;
  }
</style>



<div class="col-md-12 col-md-offset-3">
  <div>
    <form  id="show_Eligible_Voters_Category">
      <table style="width: 100%;">
        <input type="hidden" name="ac" id="ac" value="{{request()->ac}}">
        <input type="hidden" name="dd" id="dd" value="{{request()->dd}}">
        <tr>
          <td style="width: 60%;">
            <select class="form-control" name="opt" id="opt" required>
             <option value="1" @if(request()->opt  == 1) selected @endif>-- Show Eligible Voters for this AWARD Category </option>
             <option value="2" @if(request()->opt  == 2) selected @endif>-- Select Eligible Voters for this AWARD Category </option>
           </select>
         </td>
         <td>
          <button type="submit"  class="btn btn-primary">Show Results </button>
        </td>
        <td>

        </td>
      </tr>
    </table>  
  </form>
</div>



<div class="form-group">

<form id="submitFormEligibility">
<div class="pull-right" style="margin-bottom: 7px !important">
  <button type="submit"  
    @if(request()->opt  == 1) class="btn btn-danger" @else class="btn btn-primary" @endif> 
    @if(request()->opt  == 1) Remove Eligibles @else Submit Eligibles @endif
  </button>
</div>

  {{ csrf_field() }}
  <input type="hidden" id="ac" name="ac" value="{{request()->ac}}">
  <input type="hidden" id="dd" name="dd" value="{{request()->dd}}">

   @if(request()->opt  == 2)
   <input type="hidden" id="action" name="action" value="add">
    @else
    <input type="hidden" id="action" name="action" value="remove">
    @endif

<div class="table-responsive">
  <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" id="data_table" >
    <thead class="head" style="background-color:#418cd2;"> 
      <tr>
        <th>
          <!--<input type="checkbox" name="" id="checkAll" />-->
        </th>
          <th>No.</th>
          <th>File No.</th>
          <th>Name</th>  
          <th>Sex</th>    
          <th>Cadre</th>
          <th>Department</th>
          <!--       <th>Field Office</th> -->
          <th>Status</th>
        </tr> 
      </thead>        
      <tbody>


        @if(count($users) > 0)
        @php $sn = 1; 
        @endphp

        @foreach($users as $user)
        <tr>
          <td>
           <input type="hidden" name="opt" value="{{ request()->opt }}">
           <input class="form-group eligible_candidate" type="checkbox" data-group-check name="eligible[]" value="{{ $user->id }}"/>
         </td>

         <td> {{ $sn++ }}. </td>
         <td> {{ $user->emp_num }}. </td>
         <td>{{ strtoupper($user->name) }}</td>
         <td>{{ $user->sex }}</td>

         <td>{{ isset($user->job->cadre->name) ? $user->job->cadre->name : '' }}</td>
         <td>{{ isset($user->job->department) ? $user->job->department->spec : '' }}</td>
         <!--               <td> {{ isset($user->fieldOffice->name) ? $user->fieldOffice->name : '' }}</td> -->

         <td>@if(eligible($user->id, request()->ac, session('FY'),'view' ) ) 
          <span class="tag tag-success">Eligble</span>
          @else
          <span class="tag tag-danger">Not Eligible</span>
        @endif</td>
      </tr>
      @endforeach

      @endif

    </tbody>
    </table>
  </div>
  </form>

  <!--<input type="submit" class="btn btn-primary" style="background: #d33;" value="Submit Eligibles">-->
</form>
</div>          



</div>
</div>

</div>




<script type="text/javascript">
  $('#data_table').DataTable();
</script>




<script type="text/javascript">
  $(function(){

    $('#show_Eligible_Voters_Category').submit(function(event){
        event.preventDefault()
           data={
         ac:document.querySelector('#ac').value,
         dd:document.querySelector('#dd').value,
         opt:document.querySelector('#opt').value
   }
          loadEligibleVoters(`{{url('eligiblevotersmodal')}}?ac=${data.ac}&dd=${data.dd}=&opt=${data.opt}`)
    })






      $('#submitFormEligibility').submit(function(){
           event.preventDefault();
           data_Val=[];

           document.querySelectorAll('.eligible_candidate').forEach((elem,index)=>{
            if(elem.checked){

              data_Val[index]=elem.value ;
            }

           })
           
            data={
         action:document.querySelector('#action').value,
         ac:document.querySelector('#ac').value,
         dd:document.querySelector('#dd').value,
         opt:document.querySelector('#opt').value,
         eligible:data_Val,
         _token:'{{csrf_token()}}'
   }
           $.post("{{url('eligibility')}}",data,function(data_elem){
            $('#votesettingsModalBody').html(data_elem);
           })
          
      })

  })

 
 
 

</script>
