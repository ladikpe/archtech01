@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('All AWARDS Categories')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('AWARDS Categories')}}</li>
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
                tr, th{
                  color: #fff !important;
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



                      @if(count($userss) > 0)
                      @foreach($userss as $user)
                      @php
                      $splitname = explode(" ",$user->name);
                      @endphp



                      <div class="flash-message">
                        <div class="alert alert-danger" style="padding: 0px !important;">
                          <h3 class="panel-title" style="white-space: nowrap; "><span class="fa fa-line-chart"></span>Vote <b style="color: #d00;"> {{ strtoupper($splitname[0]) }} </b> for {{ base64_decode($_GET['dd']) }} </h3>
                        </div>
                      </div>

                      <div class="col-md-3"  align="center">
                        <div class="card" style=" border-right: 1px solid #c0c0c0; width: 230px;">
                          <img src="{{ !empty($user->image) ? asset('uploads/avatar/'.$user->image) : asset('uploads/avatar/avatar.jpg')  }}" class="card-img-top" alt="" style="min-height: 150px; width: 210px; border-radius: 0%;">
                          <div class="card-body">
                            <h3 class="card-title">{{ ucwords(strtolower($user->name)) }}</h3>
                            <p class="card-text" class="btn btn-primary"> 
                              {{ isset($user->job->cadre->name) ? "Cadre:".$user->job->cadre->name : '' }}
                            </p>
                            <p class="card-text" class="btn btn-primary">
                              <b style="font-weight: bold;">Birthday</b>: {{ date_format(date_create($user->dob), "F j") }} 
                            </p>
                            </div> 


                            <div style="margin-top: 20px;">
                              <a href="/startmenu?at={{$_GET['at']}}&ac={{$_GET['ac']}}&dd={{$_GET['dd']}}" class="tag tag-success"> See All Candidates </a>
                            </div>

                          </div>
                        </div>


                        <div class="card" style="float: left !important; width: 70%; margin-left: 30px;">



                          @php
                          $csswidth = @round(($progressCount['votedForCount'] / $progressCount['totalCount']) * 100, 2);
                          @endphp

                          <div style="margin-bottom: 50px; width: 100%;">
                            <big><b style="font-weight: bold;">Progress:</b> You have voted <code>{{isset($progressCount['votedForCount']) ? $progressCount['votedForCount'] : ''}}</code> of <code>{{isset($progressCount['totalCount']) ? $progressCount['totalCount'] : ''}}</code> Candidates. <b style="font-weight: bold;">Remaining</b> <code>{{isset($progressCount['remainder']) ? $progressCount['remainder'] : ''}}</code></big>
                            <div class="progress" style="margin-top: 20px;">
                              <div class="progress-bar progress-bar-success" role="progressbar"
                              aria-valuenow="{{$csswidth}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$csswidth}}%;">
                              {{$csswidth}}%
                            </div>
                          </div>
                        </div>



                        <form method="post" action="{{url('votecandidate')}}">
                          {{csrf_field()}}
                          @php $i = 1;
                          $emptyCadreConfig = 0;
                          @endphp


                          <table class="table table-striped">
                            @if(count($catlist) > 0) <!-- CHECK IF VOTING ATTRIBUTE IS SET -->
                            @foreach( $catlist as $catline)
                            @php
                            $maxvotelimit = @$catline->getPercentage( isset(Auth::user()->job->cadre->id) ? Auth::user()->job->cadre->id : '', $_GET['at'], $_GET['ac'], $catline->id );
                            $emptyCadreConfig += $maxvotelimit;
                            @endphp

                            <tr>
                              <td>

                                <h4 style="margin: 0px; margin-bottom: 10px; cursor: pointer; display: inline;" data-toggle="tooltip" data-original-title="{{ $catline->descr }}">{{$i++}}. {{ucwords($catline->name)}}:
                                </h4>
                              </td>   

                              <td><input  data-range-input-id="{{ $catline->id }}" name="value[{{ $catline->id }}]" placeholder="0" type="text" style="border: 0px; width: 15px; font-weight: bold; color: #333; display: inline;" readonly/></td>
                              <td><div data-range-id="{{ $catline->id }}" id="range" class="range" style="float: right;"></div> </td>
                              <input type="hidden" name="cadrepercent[{{ $catline->id }}]" value="{{ $maxvotelimit }}">
                            </tr>
                            @endforeach

                            <tr>
                              <td colspan="3">
                                <div>
                                  <input type="hidden" name="cadre" value="{{ isset($user->job->cadre->id) ? $user->job->cadre->id : '' }}"/>


                                  <input type="hidden" name="voted_for_id" value="{{ $user->id }}"/>
                                  <input type="hidden" name="ac" value="{{$_GET['ac']}}"/>
                                  <input type="hidden" name="at" value="{{$_GET['at']}}"/>
                                  <input type="hidden" name="dd" value="{{$_GET['dd']}}"/>
                                  <input type="hidden" name="voter_id" value="{{ Auth::user()->id }}"/>
                                  <input type="hidden" name="url" value="{{Request::fullUrl() }}"/>
                                  <input type="hidden" name="page" value="{{@$_GET['page']}}"/>

                            @if($emptyCadreConfig > 0)
                              @if($voteswitch == '1')
                                  @if(!hasVote(session('FYI'), Auth::user()->id, $_GET['ac'] ,$user->id))
                                  <button type="submit" class="btn btn-primary">Submit Vote</button>
                                  @else
                                <div class="flash-message" align="center">
                                  <div class="alert alert-danger">
                                    You Voted this <b style="font-weight: bold">Candidate</b> Already!
                                  </div>
                                </div>
                                @endif
                              @else
                                <span class="btn btn-danger">Voting Disabled</span>
                              @endif
                            @endif


                               @if($emptyCadreConfig < 1)
                                <div class="flash-message" align="center">
                                  <div class="alert alert-danger">
                                    <b style="font-weight: bold">Priority Vector</b> is not set for this AWARD category, try again later.
                                  </div>
                                </div>
                                @endif



                                </form>
                              </div>
                            </td>
                          </tr>


                        </table>
                        @else
                        <div class="flash-message">
                          <div class="alert alert-danger">
                            Voting Attributes is not set for this category. try again later
                          </div>
                        </div>
                        @endif

                        @endforeach

                        @if(!isset($_GET['page']))
                        <nav>
                          <ul class="pagination">
                            <li class="page-item disabled">
                              <a class="page-link" href="javascript:void(0)">
                                <span aria-hidden="true">←</span> Previous Candidate</a>
                              </li>
                              <li class="page-item"><a class="page-link" href="{{Request::fullUrl()}}&page=2">Next Candidate <span aria-hidden="true">→</span></a></li>
                            </ul>
                          </nav>
                          @else
                          {!! $userss->appends(Request::capture()->except('page'))->render() !!} 
                          @endif










                        </div>


                        @else
                        <div class="flash-message">
                          <div class="alert alert-danger">
                            No more Candidates to vote.
                          </div>
                        </div>
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




  <link rel="stylesheet" href="{{ asset('global/slider/css/prism.css') }}">
  <link rel="stylesheet" href="{{ asset('global/slider/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('global/slider/dist/css/asRange.css') }}">

  <script src="{{ asset('global/slider/js/jquery.toc.js') }}"></script>
  <script src="{{ asset('global/slider/js/prism.js') }}"></script>
  <script src="{{ asset('global/slider/dist/jquery-asRange.js') }}"></script>


  <script type="text/javascript">
    $(document).ready(function() {

      $("[data-range-id]").each(function(){
        var id = $(this).data('range-id');
// $(this).onChange(function(instance){
//    // alert(JSON.stringify(instance));
// });
$(this).asRange({
  step: 1,
  range: false,
  min: 0,
  max: 9,
  tip: false,
  onChange:function(instance){
// alert(JSON.stringify(instance));
//console.log(instance,id);
$('[data-range-input-id=' + id + ']').val(instance);
}
});

});

    });
  </script>

  @endsection