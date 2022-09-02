@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
@endsection
@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('Merit AWARD Winner')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('Merit AWARD Winner')}}</li>
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
                  <form method="GET" action="{{url('merit-award')}}">
                    <tr>
                      <th><label>Merit AWARD Category:</label></th>
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
                    <input type="hidden" name="control" value="VGVhbSBBV0FSRA==">
                    <button type="submit" class="btn btn-primary" >Show Merit AWARDS </button>
                  </td>

                </tr>

              </div>
            </form>
          </table> 
        </div>












            <div class="col-md-13">


              <div class="form-group">
<div class="table-responsive">
  <table class="table table-hover dataTable table-striped" id="data_table">
    <thead class="head" style="background-color:#418cd2;"> 
      <tr>
        <th>S.No</th>
       <!-- <th>Emp ID.</th> -->
        <th>Name</th>  
        <th>Sex</th> 
        <th>Year(s) in Service</th>   
      <!--  <th>Unit</th>   -->
        <th>Cadre</th>  
        <th>Department</th>  
        <th>Field Office</th>  
        <th style="display: none;"></th>
      </tr> 
    </thead>   

@if(isset($_GET['awardcategory']))
    <tbody>
      @php $sn = 1; @endphp
      @foreach($users as $user)
      <tr>
        <td> {{ $sn++ }}. </td>
       <!-- <td>{{ $user->emp_num }}</td> -->
        <td>{{ $user->name }}</td>
        <td>{{ $user->sex }}</td>
        
        <td>  {{ $user->hire_age_year }} Year(s)        </td>



      <!--  <td>  {{ isset($user->unit->spec) ? $user->unit->spec : '' }}       </td> -->
      
<td>  {{ isset($user->job->cadre->name) ? $user->job->cadre->name : '' }} </td>
<td> {{ isset($user->job->department) ? $user->job->department->spec : '' }}  </td>
<td>  {{ isset($user->fieldOffice->name) ? $user->fieldOffice->name : '' }} </td>
<td style="display: none;"></td>
      </tr>
      @endforeach

    </tbody>
@endif
  </table>

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