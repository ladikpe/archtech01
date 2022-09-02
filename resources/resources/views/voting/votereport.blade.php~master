@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('AWARDS Winners')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('AWARDS Winners')}}</li>
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
    <div class="row" data-plugin="matchHeight" data-by-row="true">
      <!-- First Row -->


      <!-- End First Row -->
      {{-- second row --}}
      <div class="col-ms-12 col-xs-12 col-md-12">
        <div class="panel panel-info panel-line">

          <div class="">





  <style type="text/css">
    .head>tr> th{
      color: #fff;
    }
    .my-btn.btn-sm {
      font-size: 0.7.5rem;
      width: 1.5rem;
      height: 1.5rem;
      padding: 0;
    }

    .page-content{
      padding-top: 0px;
    }
  </style>







    









    <div class="page-content">

     <div class="panel">
      <div class="panel-body container-fluid">
        <div class="row row-lg col-xs-12"> 
          @if (session('success'))
          <div class="flash-message">
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          </div>
          @endif
          @if (session('error'))
          <div class="flash-message">
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
          </div>
          @endif








          <div class="col-md col-md-offset-3">
            <form method="get" action="{{url('votereport')}}">
              <div class="form-group">
            <div class="table-responsive">
                <table>
                  <tr>
                    <th><label>Department:</label></th>
                    <th><label>Unit:</label></th>
                    <th><label>Field Office:</label></th>
                   <!-- <th><label>Employee Name/ID:</label></th> -->
                  </tr>


                  <tr>

                    <td>
                      <select class="form-control" name="department">
                        <option value="">-Select Department-</option>
                        @foreach($departments as $cadre)
                        <option value="{{$cadre->id }}" {{isset($_GET['department']) && $_GET['department']==$cadre->id ? 'selected' : '' }}>{{ $cadre->spec }}</option>
                        @endforeach
                      </select>
                    </td>

                    <td>
                      <select class="form-control" name="unit">
                        <option value="">-Select Unit-</option>
                        @foreach($units as $zone)
                        <option value="{{$zone->id }}" {{isset($_GET['unit']) && $_GET['unit']==$zone->id ? 'selected' : '' }}>{{$zone->spec}}</option>
                        @endforeach
                      </select>
                    </td>


                    <td>
                      <select class="form-control"  name="fieldoffice">
                        <option value="">-Select Field Office-</option>
                        @foreach($fieldoffices as $fieldoffice)
                        <option value="{{$fieldoffice->id }}"  {{isset($_GET['fieldoffice']) && $_GET['fieldoffice']==$fieldoffice->id ? 'selected' : '' }}>{{$fieldoffice->name}}</option>
                        @endforeach
                      </select>
                    </td>

                   <!-- <td>
                      <input type="text" class="form-control" value="{{ isset($_GET['name']) ?  $_GET['name'] : '' }}" name="name" autocomplete="off" />
                    </td> -->


                    <td rowspan="2">
                      <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </td>

                  </tr>
                </table>
              </div>
              </form>
            </div> 




<div class="table-responsive">
          <table class="table table-hover dataTable table-striped w-full" id="award-table" >
            <thead class="head" style="background-color:#418cd2;"> 
              <tr>
                <th>S.No</th>
                <th>Categories of AWARDS</th> 
                <th>AWARD Winners</th> 
                <th>Score</th>  
                <th>No. of Votes</th> 
                <th>Average Score</th> 
                @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
                <th>Action</th> 
                @endif
              </tr> 
            </thead>        
            <tbody>

              @if(count($awardcategory) > 0)
              @php $sno = 1; @endphp
              @foreach($awardcategory as $awardcategoryLoop)

              @php $awardWinner = $awardcategoryLoop->AWARDWinner($awardcategoryLoop->id,Request::all()); @endphp
              <tr>
                <td> {{ $sno++ }}. </td>
                <td>  {{ $awardcategoryLoop->name }} </td>
                 
                @php 
                  $groupname = '';
                @endphp 
                <td style="font-weight: bold;"> 
                  @if($awardWinner['award_type'] == '1')
                  {{ isset($awardWinner->user->name) ? $groupname = $awardWinner->user->name : 'No Votes Yet' }} 
                  
                  @elseif($awardWinner['award_type'] == '2')
                  
                  @php
                  isset($awardcategoryLoop->AWARDWinnerGroup($awardcategoryLoop->id, $awardcategoryLoop->id,Request::all())->name) ?
                  $groupname = $awardcategoryLoop->AWARDWinnerGroup($awardWinner->voted_for_id, $awardcategoryLoop->id,Request::all())->name : ''   @endphp

                  @php isset($awardcategoryLoop->AWARDWinnerGroup($awardWinner->voted_for_id, $awardcategoryLoop->id,Request::all())->spec) ?
                  $groupname =  $awardcategoryLoop->AWARDWinnerGroup($awardWinner->voted_for_id, $awardcategoryLoop->id,Request::all())->spec : ''   @endphp

                  {{   strtoupper($groupname) }}
                  @else
                  No Votes Yet
                  @endif
                </td>



                <td> {{ isset($awardWinner->voteawards->id) ? 
                 round($awardWinner->sumPercentage, 1) : 'No Votes Yet' }}  </td>
                 

                 <td>  {{ isset($awardWinner->voteawards->id) ? 
                   $awardcategoryLoop->voteNum($awardcategoryLoop->id,$awardWinner->voted_for_id,Request::all()) : 'No Votes Yet' }}   </td>

                   <td> {{ isset($awardWinner->voteawards->id) ? 
                    round($awardWinner->sumPercentage/$awardcategoryLoop->voteNum($awardcategoryLoop->id,$awardWinner->voted_for_id,Request::all()), 1) : 'No Votes Yet' }}  </td>

                    <td> 
                      <a href="uservotereport/{{isset($awardWinner->voted_for_id) ? $awardWinner->voted_for_id :''}}/{{isset($awardcategoryLoop->id) ? $awardcategoryLoop->id : ''}}?uac={{base64_encode($groupname)}}" target="_blank"> {{ isset($awardWinner->voteawards->id) ? 'View Votes' : ''}}</a>
                    </td>

                  </tr>
                  @endforeach       
                </tbody>     
              </tr>
            </tbody>
            @endif
          </table>
</div>

          <h3>{{ !$votecat->isEmpty() ? '' : 'No Results found.' }}  </h3>






        </div>
      </div>

    </div>
  </div>


</div>
















            </div> 


          </div>
        </div>

      </div>

    </div>
  </div>
</div>
<!-- End Page -->

@endsection
@section('scripts')
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
  <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{ asset('global/vendor/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>
  <script type="text/javascript">
      $(document).ready(function() {
 $('#award-table').DataTable()

      });
      
  </script>


<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


  <script>
  <?php if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray())) { ?>
  $("#award-table").DataTable( {        
"aoColumnDefs": [
      { "bSearchable": true, "aTargets": [ -2, -1 ] },
      { "bSortable": false, "aTargets": [ -1 ] }
    ],
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
  <?php } else { ?>
  $("#award-table").DataTable( {        
"aoColumnDefs": [
      { "bSearchable": false, "aTargets": [ -1] }
    ]
    });
<?php } ?>
</script>

@endsection