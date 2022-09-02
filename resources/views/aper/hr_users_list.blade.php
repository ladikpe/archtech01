@extends('layouts.master')
@section('stylesheets')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
      <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
      <link href="{{ asset('global/vendor/select2/select2.min.css') }}" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <style media="screen">

    .form-cont{
      border: 1px solid #cccccc;
      padding: 10px;
      border-radius: 5px;
    }

    #stgcont {
      list-style: none;
    }

    #stgcont li{
      margin-bottom: 10px;
    }

  </style>

@endsection
@section('content')
@php



@endphp
    <div class="page ">
    <div class="page-header">
      <h1 class="page-title">APER Evaluation</h1>
      <div class="page-header-actions">
    <div class="row no-space w-250 hidden-sm-down">

      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium">{{date("M j, Y")}}</span>

        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="counter">
          <span class="counter-number font-weight-medium" id="time">{{date('h:i s a')}}</span>

        </div>
      </div>
    </div>
  </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">

          <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                    {{ session('success') }}
                </div>
                 @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times</span> </button>
                    {{ session('error') }}
                </div>
            @endif
            <div class="panel panel-info ">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Employees</h3>
              </div>


              <div class="panel-body">
            <div class='table-responsive'>
              <table class="table table-striped" id="data_table">
                <thead>
                  <tr>
                      <th>S/N</th>
                    <th>Name</th>
                      <th>Cadre</th>
                    <th>Rank</th>
                    <th>Zone</th>
                    <th>Field office</th>
                    <th>Grade</th>
                    <th>Evaluated by</th>
                    <th>Evaluated on</th>
                    <th>Score</th>
                    <th>Total Score</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($evaluations as $evaluation)
                  @if($evaluation->user!= null && $evaluation->manager != null)
                  
                  <tr>
                      <td>{{$loop->iteration}}</td>
                    <td>{{$evaluation->user ? $evaluation->user->name :''}}</td>
                     
                      <td>{{$evaluation->user->rank?($evaluation->user->rank->cadre?$evaluation->user->rank->cadre->name:'No Cadre'):' No Cadre'}}</td>
                      <td>{{$evaluation->user->rank?$evaluation->user->rank->name:''}}</td>
                      <td>{{$evaluation->user->field_office?($evaluation->user->field_office->zone?$evaluation->user->field_office->zone->name:'No Zone'):' No Zone'}}</td>
                      <td>{{$evaluation->user->field_office?$evaluation->user->field_office->name:''}}</td>
                       <td>{{$evaluation->user->rank?($evaluation->user->rank->grade?$evaluation->user->rank->grade->level:'No Grade'):' No Grade'}}</td>
                       <td>{{$evaluation->manager->name}}</td>
                       <td>{{$evaluation->manager_approved_date=='' || $evaluation->manager_approved_date=='1970-01-01' ?'Not Saved':date('F j, Y',strtotime($evaluation->manager_approved_date))}}</td>
                       <td>{{$evaluation->score}}</td>
                       <td>{{$evaluation->total_score}}</td>

                       <td><a class="btn btn-info" href="{{ url('aper/get_hr_evaluation_assessments').'?employee='.$evaluation->user->id.'&mp='.$mp->id }}">View Evaluation</a></td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
              </div>
              </div>


        </div>


          </div>
          </div>

  </div>


</div>
@endsection
@section('scripts')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('global/vendor/select2/select2.min.js')}}"></script>
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('global/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
	$('#data_table thead tr').clone(true).appendTo( '#data_table thead' );
    $('#data_table thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

       var table= $("#data_table").DataTable( {
// "aoColumnDefs": [
//       { "bSearchable": false, "aTargets": [ -2, -1 ] },
//       { "bSortable": false, "aTargets": [ -1 ] }
//     ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'print',{
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A1'
            }
            ]
        });
         $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
} );
  </script>
@endsection
