@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('Start Voting')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('Start Voting')}}</li>
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
            <div class="table-reponsive">



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
      <!--- <h2> Available {{ isset($_REQUEST['type']) ? $_REQUEST['type'] : '' }} AWARDS </h2> -->


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

            <div class="col-md-12 col-md-offset-3">



              @if ($response)
              <div class="flash-message">
                <div class="alert alert-danger">
                  {{ $response }}
                </div>
              </div>
              @endif

              <div class="form-group">
                <div class="form-group">






    @if(count($awardcategory) > 0 && !isset($_GET['at']) && !isset($_GET['ac']))
                  <!-- <div class="flash-message">
                    <div class="alert alert-success"> -->
                     <h3> <span style="color: #d00;">{{ base64_decode($_REQUEST['type']) }}</span> Categories </h3>
            <!--        </div>
            </div> -->
            <div class="table-responsive">
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" id="data_table" style="cursor: default !important;">
              <thead class="bg-blue-600 head">
                <tr>
                  <th>S.No</th>
                  <th>Category Name</th> 
                  <th>Action</th> 
                </tr>
              </thead>
              <tbody> 
                @foreach($awardcategory as $awardcategoryLoop)
                <tr>
                 <td> {{ $loop->index + 1 }}. </td>
                 <td>{{ isset($awardcategoryLoop->award_cat) ? @$awardcategoryLoop->Awards($awardcategoryLoop->award_cat) : '' }}</td>

                 <td> 
            @if($voteswitch == '1')
                 @if(eligible(Auth::user()->id, $awardcategoryLoop->award_cat, session('FYI')) ) 
                    <a href="startmenu?at={{ isset($awardcategoryLoop->award_type) ? $awardcategoryLoop->award_type : ''}}&ac={{ isset($awardcategoryLoop->award_cat) ? $awardcategoryLoop->award_cat : '' }}&dd={{ base64_encode(@$awardcategoryLoop->Awards($awardcategoryLoop->award_cat)) }}">
                      <button class="btn btn-primary">Start Vote</button>
                    </a>  
                @else 
                  <span class="btn btn-danger">Not Eligible</span>
                @endif
            @else
                <span class="btn btn-danger">Voting Disabled</span>
            @endif
          </td>
               </tr>
              
               @endforeach
             </tbody>                
           </table>
         </div>

           @endif









 <!--DISPLAY LIST OF EMPLOYEES TO VOTE -->
 @if(isset($_GET['at']) && isset($_GET['ac']))
           <h3> Vote the "<span style="color: #d00;">{{ base64_decode(($_GET['dd'])) }}</span>"  </h3>


           <!-- CHECK OF INDIVIDUAL OR GROUP AWARD ---->

           @php
           $csswidth = @round(($progressCount['votedForCount'] / $progressCount['totalCount']) * 100, 2);
           @endphp

           <div style="margin-top: 2px; width: 80%;">
            <big><b style="font-weight: bold;">Progress:</b> You have voted <code>{{isset($progressCount['votedForCount']) ? $progressCount['votedForCount'] : ''}}</code> of <code>{{isset($progressCount['totalCount']) ? $progressCount['totalCount'] : ''}}</code> Candidates. <b style="font-weight: bold;">Remaining</b> <code>{{isset($progressCount['remainder']) ? $progressCount['remainder'] : ''}}</code></big>
            <div class="progress" style="margin-top: 5px;">
              <div class="progress-bar progress-bar-success" role="progressbar"
              aria-valuenow="{{$csswidth}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$csswidth}}%;">
              {{$csswidth}}%
            </div>
          </div>
        </div>




        @if($_GET['at'] == 1)

<div class="table-responsive">
        <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" id="data_table" >
          <thead class="head" style="background-color:#418cd2;"> 
            <tr>
              <th>S.No</th>
              <!--  <th>Emp ID.</th>  -->
              <th>Name</th>  
              <th>Sex</th>  
      <!--         <th>Cadre</th> -->
              <th>Department</th>
              <th>Unit</th>
         <!--      <th>Field Office</th>  -->
              <th>Action</th> 
            </tr> 
          </thead>        
          <tbody>

@php
$list = '';
foreach($users as $nextuser){
$list .= $nextuser->emp_num.',';}
$list = base64_encode($list);
@endphp
            @php $sn = 1;@endphp
            @foreach($users as $user)
            <tr>
              <td> {{ $loop->index +1 }}. </td>
              <!--  <td>{{ $user->emp_num }}</td> -->
              <td>{{ strtoupper($user->name) }}</td>
              <td>{{ $user->sex }}</td>

    <td>{{ isset($user->department->spec) ? $user->department->spec : '' }}</td>

          <!--     <td>{{ isset($user->job->cadre->name) ? $user->job->cadre->name : '' }}</td> -->
              <td>{{ isset($user->unit->spec) ? $user->unit->spec : '' }}</td>
              <!-- <td> {{ isset($user->fieldOffice->name) ? $user->fieldOffice->name : '' }}</td> -->




              <td>
                @if(!hasVote(session('FYI'), Auth::user()->id, $_GET['ac'] ,$user->id))
                <a href="vote/{{ $user->id }}?at={{$_GET['at']}}&ac={{$_GET['ac']}}&dd={{$_GET['dd'] }}&list={{$list}}">  <button class="btn btn-primary">Vote</button> </a> 
                @else
                <span class="btn btn-primary" style="background: #f66; padding-right: 11px; padding-left: 11px;">Voted</span>
                @endif
              </td>

            </tr>
            @endforeach

          </tbody>
        </table>
      </div>

        @else
        <!-----GROUP AWARDS-->

<div class="table-responsive">
        <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" id="data_table" >
          <thead class="head" style="background-color:#418cd2;"> 
            <tr>
              <th>S.No</th>
              <th>Name</th>    
              <th>Action</th> 
            </tr> 
          </thead>        
          <tbody>
            @php $sn = 1; @endphp
            @foreach($users as $user)
            <tr>
              <td> {{ $loop->index +1  }}. </td>
              <td>{{ strtoupper($user->name) }}  </td>

              <td> 

                @if(!hasVote(session('FYI'), Auth::user()->id, $_GET['ac'] ,$user->id))
                <a href="votegrp/{{ $user->id }}?at={{$_GET['at']}}&ac={{$_GET['ac']}}&dd={{$_GET['dd'] }}">  <button class="btn btn-primary">Vote</button> </a>
                @else
                <span class="btn btn-primary" style="background: #f66; padding-right: 11px; padding-left: 11px;">Voted</span>
                @endif



              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
</div>
        @endif


        @endif

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

