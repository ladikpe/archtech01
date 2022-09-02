<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('Cadre Settings')}}</li>
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
		              <h3 class="panel-title">Cadres</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addCadreModal">Add Cadre</button>

              			</div>
		            	</div>
		            <div class="panel-body">

	                  <table id="exampleTablePagination" data-toggle="table"
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
		                      <tr>
		                        <th >Name:</th>
		                        <th >Promotion Type:</th>
                                  <th>Ranks</th>
                                  <th>Action</th>
		                      </tr>
		                    </thead>
		                    <tbody>
                                @foreach($cadres as $cadre)
                                    <tr>
                                        <td>{{$cadre->name}}</td>
                                        <td>{{$cadre->promotion_type}}</td>
                                        <td><a class="linker" href="{{url('cadres/ranks')."?cadre_id=".$cadre->id}}" >Ranks({{count($cadre->ranks)}})</a></td>
                                        <td><a class="" title="edit" class="btn btn-icon btn-info" id="{{$cadre->id}}" onclick="prepareEditData(this.id);"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a class="" title="delete" class="btn btn-icon btn-danger" id="{{$cadre->id}}" onclick="deletecadre(this.id);"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
	   @include('settings.cadresettings.modals.addcadre')
	  {{-- edit IP modal --}}
	   @include('settings.cadresettings.modals.editcadre')
<script type="text/javascript">
  $(function() {

      $('#addCadreForm').submit(function(e){
          e.preventDefault();
          var form = $(this);
          var formdata = false;
          if (window.FormData){
              formdata = new FormData(form[0]);
          }
          $.ajax({
              url         : '{{url('cadres')}}',
              data        : formdata ? formdata : form.serialize(),
              cache       : false,
              contentType : false,
              processData : false,
              type        : 'POST',
              success     : function(data, textStatus, jqXHR){

                  toastr["success"]("Changes saved successfully",'Success');
                  $('#addCadreModal').modal('toggle');
                  $( "#ldr" ).load('{{url('cadres')}}');
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

      $('#editCadreForm').submit(function(e){
          e.preventDefault();
          var form = $(this);
          var formdata = false;
          if (window.FormData){
              formdata = new FormData(form[0]);
          }
          $.ajax({
              url         : '{{url('cadres')}}',
              data        : formdata ? formdata : form.serialize(),
              cache       : false,
              contentType : false,
              processData : false,
              type        : 'POST',
              success     : function(data, textStatus, jqXHR){

                  toastr["success"]("Changes saved successfully",'Success');
                  $('#editCadreModal').modal('toggle');
                  $( "#ldr" ).load('{{url('cadres')}}');
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
  function prepareEditData(cadre_id){
      $.get('{{ url('/cadres/get_cadre') }}',{cadre_id:cadre_id},function(data){
          // console.log(data);
          $('#editid').val(data.id);
          $('#editname').val(data.name);
          $('#editpromotion_type').val(data.promotion_type);
      });
      $('#editCadreModal').modal();
  }
  function deletecadre(cadre_id){
      alertify.confirm('Are you sure you want to delete this Cadre?', function () {


          $.get('{{ url('cadre/delete_cadre') }}',{cadre_id:cadre_id},function(data){
              if (data=='success') {
                  toastr["success"]("Cadre deleted successfully",'Success');

                  location.reload();
              }else{
                  toastr["error"]("Error deleting Cadre",'Success');
              }

          });
      }, function () {
          alertify.error('Cadre not deleted');
      });
  }

</script>
