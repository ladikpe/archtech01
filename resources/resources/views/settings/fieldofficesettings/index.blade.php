<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('Field Office Settings')}}</li>
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
		              <h3 class="panel-title">Field Offices</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addFieldOfficeModal">Add Field Office</button>

              			</div>
		            	</div>
		            <div class="panel-body">

	                  <table id="exampleTablePagination" data-toggle="table"
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
		                      <tr>
		                        <th >Name:</th>
                                  <th >Manager:</th>
                                  <th>Field Offices</th>
                                  <th>Action</th>
		                      </tr>
		                    </thead>
		                    <tbody>
                                @foreach($field_offices as $field_office)
                                    <tr>
                                        <td>{{$field_office->name}}</td>
                                        <td>{{$field_office->manager?$field_office->manager->name:''}}</td>

                                        <td><a class="" title="edit" class="btn btn-icon btn-info" id="{{$field_office->id}}" onclick="prepareEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a class="" title="delete" class="btn btn-icon btn-danger" id="{{$field_office->id}}" onclick="deletefield_office(this.id);"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
	   @include('settings.fieldofficesettings.modals.addfield_office')
	  {{-- edit IP modal --}}
	   @include('settings.fieldofficesettings.modals.editfield_office')
<script type="text/javascript">
  $(function() {

      $('#addFieldOfficeForm').submit(function(e){
          e.preventDefault();
          var form = $(this);
          var formdata = false;
          if (window.FormData){
              formdata = new FormData(form[0]);
          }
          $.ajax({
              url         : '{{url('zones')}}',
              data        : formdata ? formdata : form.serialize(),
              cache       : false,
              contentType : false,
              processData : false,
              type        : 'POST',
              success     : function(data, textStatus, jqXHR){

                  toastr["success"]("Changes saved successfully",'Success');
                  $('#addFieldOfficeModal').modal('toggle');
                  $( "#ldr" ).load('{{url('field_offices')}}');
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

      $('#editFieldOfficeForm').submit(function(e){
          e.preventDefault();
          var form = $(this);
          var formdata = false;
          if (window.FormData){
              formdata = new FormData(form[0]);
          }
          $.ajax({
              url         : '{{url('zones')}}',
              data        : formdata ? formdata : form.serialize(),
              cache       : false,
              contentType : false,
              processData : false,
              type        : 'POST',
              success     : function(data, textStatus, jqXHR){

                  toastr["success"]("Changes saved successfully",'Success');
                  $('#editFieldOfficeModal').modal('toggle');
                  $( "#ldr" ).load('{{url('field_offices')}}');
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
  function prepareEditData(field_office_id){
      $.get('{{ url('/zones/get_field_office') }}',{field_office_id:field_office_id},function(data){
          // console.log(data);
          $('#editid').val(data.id);
          $('#editname').val(data.name);
          $('#editmanager_id').val(data.manager_id);
      });
      $('#editFieldOfficeModal').modal();
  }
  function deletefield_office(field_office_id){
      alertify.confirm('Are you sure you want to delete this Field Office?', function () {


          $.get('{{ url('zones/delete_field_office') }}',{field_office_id:field_office_id},function(data){
              if (data=='success') {
                  toastr["success"]("Field Office deleted successfully",'Success');

                  location.reload();
              }else{
                  toastr["error"]("Error deleting Field Office",'Success');
              }

          });
      }, function () {
          alertify.error('Field Office not deleted');
      });
  }

</script>
