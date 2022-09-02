@extends('layouts.master')
@section('stylesheets')

    <link rel="stylesheet" href="{{ asset('assets/examples/css/apps/mailbox.css')}}">
    <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div>
        <div class="page bg-white">
          
            <div class="page-main">
                <!-- Mailbox Header -->
                <div class="page-header">
                    <h1 class="page-title">Retirement List</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Retirement List</li>
                      </ol>
                    <div class="page-header-actions">


                    </div>
                </div>
                <!-- Mailbox Content -->
                <div class="page-content container-fluid" data-plugin="asSelectable">
                    <!-- Actions -->
                    <div class='table-responsive'>
            
                    <table id="data_table" class="table">
                        <thead>
                        <tr>
                              <th>S.No</th>
                              <th>Name</th> 
                              <th>Grade</th>
                              {{-- <th>Position</th> --}}
                              <th>Rank</th>
                              <th>Status</th>
                              <th>Age</th> 
                              <th>Years of Service</th>
                              <th>Years of Service Left</th>
                              <th>Action</th>
                          </tr> 
                        </thead>
                        <tbody>
                        <?php $sno = 1; ?>
                            @foreach ($users as $user) 
                            @php
                            $yob=date('Y',strtotime($user->dob));
                            $yoh=date('Y',strtotime($user->hiredate));
                            $curyear=date('Y');

                            $dobdt = \Carbon\Carbon::parse($user->dob);
                             $hiredt = \Carbon\Carbon::parse($user->hiredate);
                                                         //$age=\Carbon\Carbon::createFromDate($dobdt->year,$dobdt->month,$dobdt->day)->age;
                                                         //$yearsofservice=\Carbon\Carbon::createFromDate($hiredt->year,$hiredt->month,$hiredt->day)->age;
                                                         $age=$curyear-$yob;
                                                         $yearsofservice=$curyear-$yoh;
                                                       @endphp 
                                       @if(($age>0 || $yearsofservice>0)&&($user->employment_status!=3||$user->employment_status!=4||$user->employment_status!=5||$user->employment_status!=6))                          
                            <tr>
                                <td>{{$sno++}} </td>                                
                                <td>{{ $user->name }} ({{ $user->emp_num }})</td>
                                <td>{{ $user->grade?$user->grade->level:'' }}</td> 
                                <td>{{ $user->rank?$user->rank->name:'' }}</td>
                                {{-- <td>{{ isset($user->job->title) ? $user->job->title : 'N/A' }} </td>--}}
                                <td>{{$user->employee_status}} {{!is_null($user->employee_status_updated_at) ? '@  '.date('Y-m-d',strtotime($user->employee_status_updated_at)) : ''}}</td>
                                <td>{{ $age }} </td>
                                <td>{{ $yearsofservice }} </td>
                                @if($age>0 && ((60-$age)<=(35-$yearsofservice)))
                                @php
                                  $yosl=60-$age;
                                @endphp
                                  @if ($yosl==0)
                                   <td><span class="tag tag-success tag-outline">
                                    {{\Carbon\Carbon::parse(date("Y-{$dobdt->month}-{$dobdt->day}",strtotime("+$yosl year")))->toFormattedDateString()}}</span></td>
                                   @elseif ($yosl<0)
                                   <td><span class="tag tag-danger tag-outline">{{$user->updateStatus(5)}} Retired</span></td>

                                   @else
                                   <td><span class="tag tag-warning tag-outline">{{\Carbon\Carbon::parse(date("Y-{$dobdt->month}-{$dobdt->day}",strtotime("+$yosl year")))->toFormattedDateString()}}</span></td> 
                                  @endif
                                
                                @elseif($yearsofservice>0 && ((35-$yearsofservice)<(60-$age)))
                                @php
                                  $yosl=35-$yearsofservice;
                                @endphp
                                  @if ($yosl==0)
                                   <td><span class="tag tag-success tag-outline">{{\Carbon\Carbon::parse(date("Y-{$dobdt->month}-{$dobdt->day}",strtotime("+$yosl year")))->toFormattedDateString()}}</span></td>
                                   @elseif ($yosl<0)
                                   <td><span class="tag tag-danger tag-outline">{{$user->updateStatus(5)}} Retired </span></td>
                                   @else
                                   <td><span class="tag tag-warning tag-outline">{{\Carbon\Carbon::parse(date("Y-{$dobdt->month}-{$dobdt->day}",strtotime("+$yosl year")))->toFormattedDateString()}}</span></td> 
                                  @endif
                                @endif
                              {{--  <td><button class="btn btn-danger btn-md" onclick="deleteEmployee({{$user->id}})"><b>X</b></button></td> --}}
                              <td></td>
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
    <!-- End Add Label Form -->
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/App/Mailbox.js')}}"></script>
    <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <!-- <script src="{{ asset('assets/examples/js/apps/mailbox.js')}}"></script> -->
    <script>
        $(document).ready(function() {
            $('.input-daterange').datepicker({
                autoclose: true,
                format:'yyyy-mm-dd'
            });
        });
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script type="text/javascript">
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

        function fnSubmit(arg)
        {
            $("#successor_id").val(arg);
            $("#update_form").submit();
        }

        function deleteEmployee($id){
            // deleteEmployee
        }

    </script>
@endsection
