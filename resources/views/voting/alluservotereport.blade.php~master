@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('All AWARD Analysis')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('All AWARD Analysis')}}</li>
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


                <div class="panel">
                  <div class="panel-body container-fluid">
                    <div class="row row-lg col-xs-13"> 
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


                      <div class="form-group">
                        <table style="width: 100%">
                          <div class="form-group col-md-13">
                            <form method="GET" action="{{url('allusersvotereport')}}">
                              <tr>
                                <th><label>AWARD Category:</label></th>
                                <th><label>AWARD Type :</label></th>
                              </tr>
                              <tr>
                                <td>
                                  <select class="form-control" name="awardcategory" id="awardcategory" required>
                                   <option></option>
                                   @foreach($awardcategory as $awardcategoryLoop)
                                   <option value="{{ $awardcategoryLoop->id }}" {{isset($_GET['awardcategory']) && $_GET['awardcategory']==$awardcategoryLoop->id ? 'selected' : '' }}>{{ ucwords($awardcategoryLoop->name) }}</option>
                                   @endforeach
                                 </select>
                               </td>

                               <td>
                                <select class="form-control" name="awardtype" id="awardtype" required>
                                 <option></option>
                                 @foreach($awardtype as $awardtypeLoop)
                                 <option value="{{ $awardtypeLoop->id }}" {{isset($_GET['awardtype']) && $_GET['awardtype']==$awardtypeLoop->id ? 'selected' : '' }}>{{ ucwords($awardtypeLoop->name) }}</option>
                                 @endforeach
                               </select>
                             </td>
                             <td>
                              <button type="submit" class="btn btn-primary" >Show Report </button>
                            </td>

                          </tr>

                        </form>
                      </div>
                    </table> 
                  </div>
















<div class="table-responsive">
                  <table class="table table-hover dataTable table-striped" id="data_table">
                    <thead class="head" style="background-color:#418cd2;"> 
                      <tr>
                        <th>S.No</th>
                        <!-- <th>Voter Name</th> -->

                        @if(isset($votingcategories))
                        @php $totalvotes = 0; @endphp                          
                        @if(@$_GET['awardtype'] == 1)
                        <th>Candidate Name</th>
                        @else
                        <th>Team Name</th>
                        @endif

                        @foreach($votingcategories as $votecategory)
                        <th data-toggle="tooltip" data-original-title="{{ ucwords($votecategory->descr) }}"> {{ ucwords($votecategory->name) }}</th>              
                        @endforeach
                        <th>Score</th>
                        <th>Total Votes</th>
                        @if($_GET['awardtype'] == 1)  <th>Unit</th> @endif
              <!--<th>Department</th>
                <th>Field Office</th>-->
                @if(Auth::user()->role==Config::get('constants.roles.Admin_User'))
                <th>Action</th> 
                @endif
                <th style="display: none;"></th>
              </tr> 
            </thead> 
            <tbody>
              @php $sno = 1; @endphp
              @foreach($voting as $vote)
              <tr>
                <td width="5%"> {{ $sno++ }}. </td>
                <!-- <td>  {{ isset($vote->votername->name) ? $vote->votername->name : '' }}  </td> -->

                <td>  
                  @php 
                  if($_GET['awardtype'] == 1){
                  echo isset($vote->votedname->name) ? $vote->votedname->name : 'NULL USER';
                  isset($vote->votedname->name) ? $groupname = $vote->votedname->name : $groupname = 'NULL USER';
                }
                else{
                echo !empty(strtoupper($vote->AWARDWinnerGroup($vote->voted_for_id, $vote->award_cat, Request::all())['name'])) ? strtoupper($vote->AWARDWinnerGroup($vote->voted_for_id, $vote->award_cat, Request::all())['name']) : '';

                
                $groupname = !empty(strtoupper($vote->AWARDWinnerGroup($vote->voted_for_id, $vote->award_cat, Request::all())['name'])) ? strtoupper($vote->AWARDWinnerGroup($vote->voted_for_id, $vote->award_cat, Request::all())['name']) : '';


                //$groupname = strtoupper($vote->AWARDWinnerGroup($vote->voted_for_id, $vote->award_cat, Request::all())['name']);
              }
              @endphp
            </td> 

            @php
            $sumscore = 0;
            @endphp

            @foreach($votingcategories as $votecategory)
            @php
            $sumscore += $votecategory->sumcategory($vote->voted_for_id, $votecategory->id);
            @endphp

            <td> {{ round($votecategory->sumcategory($vote->voted_for_id, $votecategory->id), 1) }}</td>      

            @endforeach

            <td> {{ round($sumscore, 1) }} </td>


            <td> {{  !empty($vote->voteNum($vote->award_cat, $vote->voted_for_id, Request::all())) ? $vote->voteNum($vote->award_cat, $vote->voted_for_id, Request::all()) : ''  }}  </td>


            @if($_GET['awardtype'] == 1)  <td> {{ isset($vote->user->unit->spec) ? $vote->user->unit->spec : '' }} </td> @endif 

             <!-- <td> {{ isset($vote->user->job->department) ? $vote->user->job->department->spec : '' }}  </td>
              <td>  {{ isset($vote->user->fieldOffice->name) ? $vote->user->fieldOffice->name : '' }} </td> -->

              @if(Auth::user()->role==Config::get('constants.roles.Admin_User'))
              <td> <a href="uservotereport/{{isset($vote->voted_for_id) ? $vote->voted_for_id :''}}/{{isset($vote->award_cat) ? $vote->award_cat : ''}}?uac={{base64_encode($groupname)}}" target="_blank"> View Votes </a>
              </td>
              @endif
              <td style="display: none;"></td>
            </tr>
            @endforeach   
          </tbody>    
        </table>
        @else
      </table>
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


<script type="text/javascript">
  (function($){
    $(function(){


      var listeners = {};

      function attach(tag,cb){
        listeners[tag] = listeners[tag] || [];
        listeners[tag].push(cb);
      }

      function notify(tag,data){
        if (listeners[tag]){
          listeners[tag].forEach(function(v,k){
            v(data);
          });
        }
      }



      function linkDropDowns($first,$second){
var $awardcategory = $('#' + $first); //'#awardcategory'
var $awardtype = $('#' + $second); //'#awardtype'
attach('award-changed',function(data){
  data = data.toLowerCase();

  if (data.split(' ').indexOf('department') != -1 || data.split(' ').indexOf('unit') != -1 || data.split(' ').indexOf('zone of') != -1 || data.split(' ').indexOf('office') != -1){
    $awardtype.val(2);
  }else{
    $awardtype.val(1);
  }

}); 

$awardcategory.on('change',function(){
// alert('okkkk');
//option:selected").text()
notify('award-changed',$('#' + $first + ' option:selected').text());
});

}

linkDropDowns('awardcategory','awardtype');
});
  })(jQuery);

</script>
@endsection