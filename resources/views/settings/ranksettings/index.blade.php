<div class="page-header">
  		<h1 class="page-title">{{__('All Settings')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item ">{{__('Rank Settings')}}</li>
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
		              <h3 class="panel-title">Ranks for {{$cadre->name}}</h3>
		              <div class="panel-actions">
                			<button class="btn btn-info" data-toggle="modal" data-target="#addRankModal">Add Rank</button>

              			</div>
		            	</div>
		            <div class="panel-body">

	                  <table id="dataTable" data-toggle="table"
		                  data-query-params="queryParams" data-mobile-responsive="true"
		                  data-height="400" data-pagination="true" data-search="true" class="table table-striped">
		                    <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Grade</th>
                                <th>Exam No Prefix</th>
                                <th>Action</th>
                            </tr>

		                    </thead>
		                    <tbody>
                            @foreach ($ranks as $k=>$rank)

                                <tr data-index='{{$rank->id}}' data-position='{{$rank->position}}' style="cursor: pointer;" title="drag to re-order" data-toggle="tooltip" data-placement="top">
                                    <td>
                                        {{$k+1}}
                                    </td>
                                    <td>
                                        {{$rank->name}}
                                    </td>
                                    <td>
                                        {{$rank->grade?$rank->grade->level : 0}}
                                    </td>
                                    <td>
                                        {{$rank->exam_no_prefix}}
                                    </td>

                                    <td>
                                        <a href="#"  onclick="prepareEditData({{$rank->id}})" class="btn btn-sm btn-success">Edit</a>
                                        <a href="#" onclick="deleterank({{$rank->id}})" class="btn btn-sm btn-danger">Remove</a>
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
	   @include('settings.ranksettings.modals.addrank')
	  {{-- edit IP modal --}}
	   @include('settings.ranksettings.modals.editrank')
<script type="text/javascript" src="{{ asset('global/vendor/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
  $(function() {

      $('#addRankForm').submit(function(e){
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
                  $('#addRankModal').modal('toggle');
                  $( "#ldr" ).load('{{url('cadres/ranks')}}?cadre_id={{$cadre->id}}');
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

      $('#editRankForm').submit(function(e){
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
                  $('#editRankModal').modal('toggle');
                  $( "#ldr" ).load('{{url('cadres/ranks')}}?cadre_id={{$cadre->id}}');
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
  function prepareEditData(rank_id){
      $.get('{{ url('/cadres/get_rank') }}',{rank_id:rank_id},function(data){
          // console.log(data);
          $('#editrank_id').val(data.id);
          $('#editrankname').val(data.name);
          $('#editrankgrade_id').val(data.grade_id);
      });
      $('#editRankModal').modal();
  }
  function deleterank(rank_id){
      alertify.confirm('Are you sure you want to delete this Rank?', function () {


          $.get('{{ url('cadres/delete_rank') }}',{rank_id:rank_id},function(data){
              if (data=='success') {
                  toastr["success"]("Rank deleted successfully",'Success');

                  location.reload();
              }else{
                  toastr["error"]("Error deleting Rank",'Success');
              }

          });
      }, function () {
          alertify.error('Rank not deleted');
      });
  }

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable tbody').sortable({
            update: function (event, ui) {
                $(this).children().each(function (index) {
                    if ($(this).attr('data-position') != (index+1)) {
                        $(this).attr('data-position', (index+1)).addClass('updated');
                    }
                });

                saveNewPositions();
            }
        });
    });

    function saveNewPositions() {
        var positions = [];
        $('.updated').each(function () {
            positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
            $(this).removeClass('updated');
        });

        $.ajax({
            url: '{{url('cadres')}}',
            method: 'POST',
            dataType: 'text',
            data: {
                _token:'{{csrf_token()}}',
                type:'rank_positions',

                positions: positions
            }, success: function (response) {
                console.log(response);
            }
        });
    }
</script>
