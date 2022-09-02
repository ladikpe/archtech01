
<table class="table table-striped" id="data_table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Staff Id</th>
                        <th>Zone</th>
                        <th>Field Office</th>
                        <th>Department</th>
                        @foreach($aper_info['year'] as $year)
                        <th>{{$year}}</th>
                        @endforeach
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($aper_info as $detail)
                         @if(isset($detail['name']))
                      <tr>
                         
                        <td>{{$detail['name']}}</td>
                         <td>{{$detail['emp_num']}}</td>
                        <td>{{$detail['zone']}}</td>
                        <td>{{$detail['field_office']}}</td>
                         <td>{{$detail['department']}}</td>
                         @foreach($detail['scores'] as $year)
                        <th>{{$year}}</th>
                        @endforeach
                        <td><a href="{{ route('users.edit',['id'=>$detail['id']])}}" target="_blank" class="btn btn-primary text-white" style="color:#fff">view profile</a></td>
                      </tr>
                      @endif
                     @endforeach
                    </tbody>
                  </table>
                  <script>
        //                   $(document).ready(function(){
        //     $("#search2").on("keyup", function() {
                
        //         var value = $(this).val().toLowerCase();
                
        //         $("#table1 tr").filter(function() {
        //             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //         });
        //     });
        // });
                  </script>
 
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
           "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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