@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title"> Eligible Voters  for <span style="color: #d00;"> {{ base64_decode(@$_GET['dd']) }} </span> AWARD</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('Eligible Voters')}}</li>
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
</style>



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





        <p>
          <form method="GET" action="{{url('eligibility')}}">
            <table style="width: 100%;">
          <input type="hidden" name="ac" value="{{$_GET['ac']}}">
          <input type="hidden" name="dd" value="{{$_GET['dd']}}">
              <tr>
                <td style="width: 60%;">
                  <select class="form-control" name="opt" required>
                   <option value="1" @if(@$_GET['opt']  == 1) selected @endif>-- Show Eligible Voters for this AWARD Category </option>
                   <option value="2" @if(@$_GET['opt']  == 2) selected @endif>-- Select Eligible Voters for this AWARD Category </option>
                 </select>
               </td>
               <td>
          <button type="submit" class="btn btn-primary">Show Results </button>
            </td>
                        <td>
              
              </td>
            </tr>
          </table>  
          </form>
        </p>




        <div class="form-group">
    <form action="eligibility" method="post">

<button type="submit" 
@if(@$_GET['opt']==1) class="btn btn-danger" @else class="btn btn-primary" @endif> 
@if(@$_GET['opt']==1) Remove Eligibles @else Submit Eligibles @endif
</button>

          <input type="hidden" name="ac" value="{{$_GET['ac']}}">
          <input type="hidden" name="dd" value="{{$_GET['dd']}}">
          {{ csrf_field() }}
          <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" id="data_table" >
            <thead class="head" style="background-color:#418cd2;"> 
              <tr>
                <th>
                  <input type="checkbox" name="" id="checkAll" /></th>
                  <th>No.</th>
                  <th>File No.</th>
                  <th>Name</th>  
                  <th>Sex</th>    
                  <th>Cadre</th>
                  <th>Department</th>
                  <!--       <th>Field Office</th> -->
                  <th>Status</th>
                </tr> 
              </thead>        
              <tbody>


@if(count($users) > 0)

@if(@$_GET['opt']  == 2)

                @php $sn = 1; 
                /* @if(eligible($user->id, $_GET['ac'], session('FY'),'view') ) checked @endif*/
                @endphp
                @foreach($users as $user)
                <tr>
                  <td>
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="opt" value="{{ @$_GET['opt'] }}">
                    <input class="form-group" type="checkbox" data-group-check name="eligible[]" value="{{ $user->id }}"/>
                  </td>

                  <td> {{ $sn++ }}. </td>
                  <td> {{ $user->emp_num }}. </td>
                  <td>{{ strtoupper($user->name) }}</td>
                  <td>{{ $user->sex }}</td>

                  <td>{{ isset($user->job->cadre->name) ? $user->job->cadre->name : '' }}</td>
                  <td>{{ isset($user->job->department) ? $user->job->department->spec : '' }}</td>
                  <!--               <td> {{ isset($user->fieldOffice->name) ? $user->fieldOffice->name : '' }}</td> -->

                  <td>@if(eligible($user->id, $_GET['ac'], session('FY'),'view' ) ) 
                    <span class="tag tag-success">Eligble</span>
                    @else
                    <span class="tag tag-danger">Not Eligible</span>
                  @endif</td>
                </tr>
                @endforeach

@else

              @php $sn = 1; 
              /* @if(eligible($user->id, $_GET['ac'], session('FY') ,'view') ) checked @endif */
              @endphp 
              @foreach($users as $user)
                <tr>

                  <td>
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="opt" value="{{ @$_GET['opt'] }}">
                    <input class="form-group" type="checkbox" data-group-check name="eligible[]" value="{{ $user->id }}" />
                  </td>

                  <td> {{ $sn++ }}. </td>
                  <td> {{ $user->emp_num }}. </td>
                  <td>{{ strtoupper($user->name) }}</td>
                  <td>{{ $user->sex }}</td>

                  <td>{{ isset($user->job->cadre->name) ? $user->job->cadre->name : '' }}</td>
                  <td>{{ isset($user->job->department) ? $user->job->department->spec : '' }}</td>
                  <!--               <td> {{ isset($user->fieldOffice->name) ? $user->fieldOffice->name : '' }}</td> -->

                  <td>@if(eligible($user->id, $_GET['ac'], session('FY'),'view' ) ) 
                    <span class="tag tag-success">Eligble</span>
                    @else
                    <span class="tag tag-danger">Not Eligible</span>
                  @endif</td>
                </tr>
                @endforeach


@endif


@else

    NO eligible

@endif




              </tbody>
            </table>
          </form>

            <script type="text/javascript">
              $(function(){
                $('#checkAll').on('click',function(){
                  $('input:checkbox').prop('checked',this.checked);
                })
              })
   /** (function($){
      $(function(){
           
        let $el = $('#check-all');


        setInterval(function(){

          checkAll($el);

        },100);
         
         function checkAll($el){
          //data-group-check

          if ($el.is(':checked')){
            $('[data-group-check]').each(function(){
               if (!$(this).is(':checked')){
                 $(this).trigger('click');
               }
            });   //.trigger('click');
          }else{
            $('[data-group-check]').each(function(){
               if ($(this).is(':checked')){
                 $(this).trigger('click');
               }
            });   //.trigger('click');
          }


         }

      });
    })(jQuery); **/
  </script>
  <!--<input type="submit" class="btn btn-primary" style="background: #d33;" value="Submit Eligibles">-->
</form>
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