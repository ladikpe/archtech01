<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('Zone Settings')}}</li>
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
		              <h3 class="panel-title">Zones</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addZoneModal">Add Zone</button>

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
                                @foreach($zones as $zone)
                                    <tr>
                                        <td>{{$zone->name}}</td>
                                        <td>{{$zone->manager?$zone->manager->name:''}}</td>

                                        <td><a class="linker" href="{{url('zones/field_offices')."?zone_id=".$zone->id}}" >Field Offices({{count($zone->field_offices)}})</a></td>
                                        <td><a class="" title="edit" class="btn btn-icon btn-info" id="{{$zone->id}}" onclick="prepareEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a class="" title="delete" class="btn btn-icon btn-danger" id="{{$zone->id}}" onclick="deletezone(this.id);"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
	   @include('settings.zonesettings.modals.addzone')
	  {{-- edit IP modal --}}
	   @include('settings.zonesettings.modals.editzone')
<script type="text/javascript">
  $(function() {

      $('#addZoneForm').submit(function(e){
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
                  $('#addZoneModal').modal('toggle');
                  $( "#ldr" ).load('{{url('zones')}}');
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

      $('#editZoneForm').submit(function(e){
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
                  $('#editZoneModal').modal('toggle');
                  $( "#ldr" ).load('{{url('zones')}}');
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
  function prepareEditData(zone_id){
      $.get('{{ url('/zones/get_zone') }}',{zone_id:zone_id},function(data){
          // console.log(data);
          $('#editid').val(data.id);
          $('#editname').val(data.name);
          $('#editmanager').val(data.manager_id);
      });
      $('#editZoneModal').modal();
  }
  function deletezone(zone_id){
      alertify.confirm('Are you sure you want to delete this Zone?', function () {


          $.get('{{ url('zones/delete_zone') }}',{zone_id:zone_id},function(data){
              if (data=='success') {
                  toastr["success"]("Zone deleted successfully",'Success');

                  location.reload();
              }else{
                  toastr["error"]("Error deleting Zone",'Success');
              }

          });
      }, function () {
          alertify.error('Zone not deleted');
      });
  }

</script>
