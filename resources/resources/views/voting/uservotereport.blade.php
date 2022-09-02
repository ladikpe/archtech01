@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('Employee Report')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('Employee Report')}}</li>
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

          <div class="panel-body">
            <div class="table-reponsive">












    









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

            @php
             if(@$_GET['ctrl']){$status = 'Won';}else{$status = '';}
            @endphp


            <h3> {{ base64_decode($_GET['uac']) }} - {{ @$status }} <span style="color: #d00;">"{{ isset($ac->name) ? $ac->name : '' }}"</span> AWARD   </h3>




            @php $totalvotes = 0; @endphp
            <table class="table table-hover tabletable-striped dataTable" id="data_table">
              <thead> 
                <tr>
                  <th>S.No</th>
                  <th>Voter's Name</th> 

                  @foreach($awardcategory as $awardcategoryLoop)
                  <th data-toggle="tooltip" data-original-title="{{ ucwords($awardcategoryLoop->descr) }}"> {{$awardcategoryLoop->name}}  </th>
                  @endforeach

                  @if(Auth::user()->role==Config::get('constants.roles.Admin_User'))
                  <!-- <th>Action</th>  -->
                  @endif

                  <th>Score</th> 
                  <th style="display: none;"></th>
                </tr> 
              </thead> 
              <tbody>


                @php $sno = 1; @endphp
                @foreach($voting as $vote)
                <tr>
                  <td width="5%"> {{ $sno++ }}. </td>
                  <td> {{ isset($vote->votername->name) ? $vote->votername->name : '' }}</td>

                  @php
                  $sumscore = 0;
                  @endphp

                  @foreach($awardcategory as $awardcategoryLoop)
                  @php
                  $votepercentage = @$vote->userVotepercentage($vote->voted_for_id, $vote->voter_id, $awardcategoryLoop->award_cat, $awardcategoryLoop->id);

                  $sumscore += $votepercentage;

                  @endphp      
                  <td> {{ isset($votepercentage) ? round($votepercentage, 1) : '' }}   </td>

                  @endforeach    
                  <td> {{ round($sumscore, 1) }} </td>     
                  <td style="display: none;"></td>   
                </tr>
                @endforeach


              </tbody>     
              
            </tbody>
          </table>

















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
@endsection

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script>
  <?php if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray())){ ?>
    $("#data_table").DataTable( {        
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
    $("#data_table").DataTable( {        
      "aoColumnDefs": [
      { "bSearchable": false, "aTargets": [ -1] }
      ]
    });
  <?php } ?>
</script>