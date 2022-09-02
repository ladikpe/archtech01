<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('Pension Fund Administrator Settings')}}</li>
		    <li class="breadcrumb-item active">{{__('You are Here')}}</li>
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
      	<div class="row">
        	<div class="col-md-12 col-xs-12">


		          <div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Pension Fund Adminstrators</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addPFAModal">Add PFA</button>

              			</div>
		            	</div>
		            <div class="panel-body">

	                  <table id="exampleTablePagination" data-toggle="table"
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
		                      <tr>
		                        <th >Name:</th>
{{--                                  <th>Ranks</th>--}}
                                  <th>Action</th>
		                      </tr>
		                    </thead>
		                    <tbody>
                                @foreach($pfas as $pfa)
                                    <tr>
                                        <td>{{$pfa->name}}</td>
{{--                                        <td><a href="{{url('pfas/ranks')."?pfa_id=".$pfa->id}}" >Ranks({{count($pfa->ranks)}})</a></td>--}}
                                        <td><a class="" title="edit" class="btn btn-icon btn-info" id="{{$pfa->id}}" onclick="prepareEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a class="" title="delete" class="btn btn-icon btn-danger" id="{{$pfa->id}}" onclick="deletepfa(this.id);"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

		                    </tbody>
	                  </table>
	          		</div>
	          		</div>
	        	</div>
	    	</div>
	    	<div class="col-md-12 col-xs-12">

	    	</div>
		</div>
	  </div>
{{-- Add IP Modal --}}
	   @include('settings.pfasettings.modals.addpfa')
	  {{-- edit IP modal --}}
	   @include('settings.pfasettings.modals.editpfa')
<script type="text/javascript">
  $(function() {

      $('#addPFAForm').submit(function(e){
          e.preventDefault();
          var form = $(this);
          var formdata = false;
          if (window.FormData){
              formdata = new FormData(form[0]);
          }
          $.ajax({
              url         : '{{url('pfas')}}',
              data        : formdata ? formdata : form.serialize(),
              cache       : false,
              contentType : false,
              processData : false,
              type        : 'POST',
              success     : function(data, textStatus, jqXHR){

                  toastr["success"]("Changes saved successfully",'Success');
                  $('#addPFAModal').modal('toggle');
                  $( "#ldr" ).load('{{url('pfas')}}');
              },
              error:function(data, textStatus, jqXHR){
                  jQuery.each( data['responseJSON'], function( i, val ) {
                      jQuery.each( val, function( i, valchild ) {
                          toastr["error"](valchild[0]);
                      });
                  });
              }
          });

      });

      $('#editPFAForm').submit(function(e){
          e.preventDefault();
          var form = $(this);
          var formdata = false;
          if (window.FormData){
              formdata = new FormData(form[0]);
          }
          $.ajax({
              url         : '{{url('pfas')}}',
              data        : formdata ? formdata : form.serialize(),
              cache       : false,
              contentType : false,
              processData : false,
              type        : 'POST',
              success     : function(data, textStatus, jqXHR){

                  toastr["success"]("Changes saved successfully",'Success');
                  $('#editPFAModal').modal('toggle');
                  $( "#ldr" ).load('{{url('pfas')}}');
              },
              error:function(data, textStatus, jqXHR){
                  jQuery.each( data['responseJSON'], function( i, val ) {
                      jQuery.each( val, function( i, valchild ) {
                          toastr["error"](valchild[0]);
                      });
                  });
              }
          });

      });






  });
  function prepareEditData(pfa_id){
      $.get('{{ url('/pfas/get_pfa') }}',{pfa_id:pfa_id},function(data){
          // console.log(data);
          $('#editid').val(data.id);
          $('#editname').val(data.name);
      });
      $('#editPFAModal').modal();
  }
  function deletepfa(pfa_id){
      alertify.confirm('Are you sure you want to delete this Pension Fund Adminstrator?', function () {


          $.get('{{ url('pfa/delete_pfa') }}',{pfa_id:pfa_id},function(data){
              if (data=='success') {
                  toastr["success"]("PFA deleted successfully",'Success');

                  location.reload();
              }else{
                  toastr["error"]("Error deleting PFA",'Success');
              }

          });
      }, function () {
          alertify.error('PFA not deleted');
      });
  }

</script>
