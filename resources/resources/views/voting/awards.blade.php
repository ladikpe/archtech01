@extends('layouts.master')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">


@endsection

@section('content')
<!-- Page -->
<div class="page ">
  <div class="page-header">
    <h1 class="page-title">{{__('All AWARD Categories')}}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
      <li class="breadcrumb-item active">{{__('AWARD Categories')}}</li>
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
                
                .enable{
                  float: right; margin-right: 30px;  background: #080; color: #fff;
                }
                .disable{
                  float: right; margin-right: 30px;  background: #d00; color: #fff;
                }
                .panel-title{
                  padding: 10px;
                }
              </style>


              <!---VOTING SWITCH CONTROL -->
              <div style="float: right; margin-left: 15px;">
                @if($voteswitch == '1')
                <a href="/=SW5kaXZpZHVhbCBBV0FSRA==/0" class="disable btn">Disable Voting</a>
                @else
                <a href="/=SW5kaXZpZHVhbCBBV0FSRA==/1" class="enable btn ">Enable Voting</a>
                @endif
              </div>



              <div style="float: right;">
                <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#createModuleModal">New AWARD Category</button>
              </div>





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

                      <div class="col-md-13 ">




                        <!--- edit module -->
                        <div class="modal fade in modal-3d-flip-horizontal modal-primary" id="editModuleModal" aria-hidden="true" aria-labelledby="editModuleModal"
                        role="dialog" tabindex="-1">

                        <div class="modal-dialog ">

                          <form class="form-horizontal" id="edit_module_form1" role="form" method="post" action="updatecat">

                            <div class="modal-content">        
                              <div class="modal-header" >
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" id="training_title">Edit AWARD Category Name</h4>
                              </div>
                              <div class="modal-body">         

                                <div class="col-xs-12">            
                                  <div class="col-xs-12"> 
                                    <div class="form-group">
                                      <input type="hidden" class="form-control" id="id" name="id" placeholder="" value="" required />
                                      <label>Category Name:</label>
                                      <input type="text" class="form-control" id="name" name="name" placeholder="" value="" style="" autocomplete="off" required />
                                    </div>          
                                  </div>
                                  <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
                                </div>        
                              </div>
                              <div class="modal-footer">
                                <div class="col-xs-12">
                                  {{ csrf_field() }}
                                  <div style="margin-left: 9px;" class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="submit" style="margin-right: 10px;" class="btn btn-primary waves-effect" id="editmodule_btn" value="Save"></span>

                                    <span class="no-left-padding"><input type="button" class="btn btn-default waves-effect" value="Cancel"  data-dismiss="modal"></span>
                                  </div>
                                </div>
                                <!-- End Example Textarea -->
                              </div>
                            </div>
                          </form>
                        </div>

                      </div>
                    </div>
                    <!-- edit module modal end -->




                    <!--- create module -->
                    <div class="modal fade in modal-3d-flip-horizontal modal-primary" id="createModuleModal" aria-hidden="true" aria-labelledby="createModuleModal"
                    role="dialog" tabindex="-1">

                    <div class="modal-dialog ">

                      <form class="form-horizontal" id="create_module_form" role="form" method="post" action="cawards">

                        <div class="modal-content">        
                          <div class="modal-header" >
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="training_title">Create New AWARD Category</h4>
                          </div>
                          <div class="modal-body">         

                            <div class="col-xs-12">            
                              <div class="col-xs-12"> 
                                <div class="form-group">
                                  <label style="font-weight: bold;">Category Name:</label>
                                  <input type="text" autocomplete="off" class="form-control" id="name" name="name" placeholder="" value="" style="" required />
                                </div>   

                                <div class="form-group">
                                  <label style="font-weight: bold;">AWARD Type:</label>
                                  <select class="form-control" name="awardtype" id="awardtype" required>
                                   <option></option>
                                   @foreach($awardtype as $awardtypeLoop)
                                   <option value="{{ $awardtypeLoop->id }}" {{isset($_GET['awardtype']) && $_GET['awardtype']==$awardtypeLoop->id ? 'selected' : '' }}>{{ ucwords($awardtypeLoop->name) }}</option>
                                   @endforeach
                                 </select>
                               </div>
                               <input type="hidden" class="form-control" id="id" name="id" placeholder="" value="" required />


                             </div>
                             <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
                           </div>        
                         </div>
                         <div class="modal-footer">
                          <div class="col-xs-12">
                            {{ csrf_field() }}
                            <div style="margin-left: 9px;" class="text-xs-left"><span class="no-left-padding" id="btn_div"><input type="submit" style="margin-right: 10px;" class="btn btn-primary waves-effect" id="editmodule_btn" value="Save"></span>

                              <span class="no-left-padding"><input type="button" class="btn btn-default waves-effect" value="Cancel"  data-dismiss="modal"></span>
                            </div>
                          </div>
                          <!-- End Example Textarea -->
                        </div>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
              <!-- Add module modal end -->







              <div class="panel-heading">
               <h3 class="panel-title">Individual AWARDS</h3>
             </div>
             <table class="table table-hover tabletable-striped dataTable">
              <thead class="bg-blue-600 head">
                <tr>
                  <th>S.No</th>
                  <th>Category Name</th> 
                  <th>AWARD Type</th> 
                  <th>Eligible Voter(s)</th> 
                  <th>Created At</th> 
                  @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
                  <th colspan="3">Action</th> 
                  @endif
                </tr> 
              </thead> 


              <tbody> 
                @php $sno = 1; @endphp
                @foreach ($awards as $award)                            
                <tr id="tr{{ $award->id }}">
                  <td>{{$sno++}}. </td>                                
                  <td>{{ ucwords($award->name) }}</td>

                  <td> {{ $award->AWARDType($award->award_type)->name }}  </td>

                  
                  

                  <td> {{ $award->AWARDEligibilityCount($award->id) }}  </td>

                  <td> {{ date("F j, Y, g:i a", strtotime($award->created_at)) }} </td>


                  @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))

                  <td>
                    <span style="cursor: pointer;"><a href="eligibility?ac={{$award->id}}&opt=1&&dd={{ base64_encode($award->name) }}" class="my-btn btn-sm text-primary" data-toggle="tooltip" data-original-title="Eligible Voters"><i class="icon wb-users" aria-hidden="true"></i></a></span>
                    @endif
                  </td>


                  

                  <td><span style="cursor: pointer;"><a class="my-btn  btn-sm text-primary" data-create="{{ $award->id }}" data-value="{{ $award->name }}" data-toggle="modal" data-target="#editModuleModal"><i class="icon wb-pencil" aria-hidden="true"  data-toggle="tooltip" data-original-title="Edit Individual AWARD"></i></a></span></td>

                  <td>     <span style="cursor: pointer;"><a data-id="{{ $award->id }}" data-remove="{{ $award->id }}" data-name="{{ $award->name }}" class="my-btn text-danger btn-sm"  data-toggle="tooltip" data-original-title="Delete Individual AWARD" ><i class="icon wb-trash" aria-hidden="true"></i></a></span></td>

                  @endif

                  @endforeach 

                </tr>
              </tbody>
            </table>








            <br/>
            <div class="panel-heading">
             <h3 class="panel-title">Team AWARDS</h3>
           </div>
           <table class="table table-hover tabletable-striped dataTable">
            <thead class="bg-blue-600 head">
              <tr>
                <th>S.No</th>
                <th>Category Name</th> 
                <th>AWARD Type</th>
                <th>Eligible Voter(s)</th> 
                <th>Created At</th> 
                @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
                <th colspan="3">Action</th> 
                @endif
              </tr> 
            </thead> 


            <tbody> 
              @php $sno = 1; @endphp
              @foreach ($awards2 as $award)                            
              <tr id="tr{{ $award->id }}">
                <td>{{$sno++}}. </td>                                
                <td>{{ ucwords($award->name) }}</td>

                <td> {{ $award->AWARDType($award->award_type)->name }}  </td>

                <td>{{ $award->AWARDEligibilityCount($award->id) }}</td>

                <td> {{ date("F j, Y, g:i a", strtotime($award->created_at)) }} </td>



                @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
                <td><span style="cursor: pointer;"><a href="eligibility?ac={{$award->id}}&opt=1&&dd={{ base64_encode($award->name) }}" class="my-btn btn-sm text-primary" data-toggle="tooltip" data-original-title="Eligible Voters"><i class="icon wb-users" aria-hidden="true"></i></a></span></td>


                <td><span style="cursor: pointer;"><a class="my-btn  btn-sm text-primary" data-create="{{ $award->id }}" data-value="{{ $award->name }}" data-toggle="modal" data-target="#editModuleModal"><i class="icon wb-pencil" aria-hidden="true"  data-toggle="tooltip" data-original-title="Edit Team AWARD"></i></a></span></td>

                <td>     <span style="cursor: pointer;"><a data-id="{{ $award->id }}" data-remove="{{ $award->id }}" data-name="{{ $award->name }}" class="my-btn text-danger btn-sm"  data-toggle="tooltip" data-original-title="Delete Team AWARD"><i class="icon wb-trash" aria-hidden="true"></i></a></span></td>
                @endif

                @endforeach 

              </tr>
            </tbody>
          </table>












          <br/>
          <div class="panel-heading">
           <h3 class="panel-title">Merit AWARDS</h3>
         </div>
         <table class="table table-hover tabletable-striped dataTable" id="dataTable">
          <thead class="bg-blue-600 head">
            <tr>
              <th>S.No</th>
              <th>Category Name</th> 
              <th>AWARD Type</th> 
              <th>Created At</th> 
              @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
              <th colspan="2">Action</th> 
              @endif
            </tr> 
          </thead> 


          <tbody> 
            @php $sno = 1; @endphp
            @foreach ($awards3 as $award)                            
            <tr id="tr{{ $award->id }}">
              <td>{{$sno++}}. </td>                                
              <td>{{ ucwords($award->name) }}</td>

              <td> {{ $award->AWARDType($award->award_type)->name }}  </td>

              <td> {{ date("F j, Y, g:i a", strtotime($award->created_at)) }} </td>


              @if(in_array(\Auth::user()->email, \App\votehr::pluck('email')->toArray()))
              <td><span style="cursor: pointer;"><a class="my-btn  btn-sm text-primary" data-create="{{ $award->id }}" data-value="{{ $award->name }}" data-toggle="modal" data-target="#editModuleModal"><i class="fa fa-edit" aria-hidden="true"  data-toggle="tooltip" data-original-title="Edit Merit AWARD"></i></a></span></td>

              <td>     <span style="cursor: pointer;"><a data-id="{{ $award->id }}" data-remove="{{ $award->id }}" data-name="{{ $award->name }}" class="my-btn text-danger btn-sm"  data-toggle="tooltip" data-original-title="Delete Merit AWARD"><i class="icon wb-trash" aria-hidden="true"></i></a></span></td>
              @endif
              @endforeach 

            </tr>
          </tbody>
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
<!-- End Page -->

@endsection
