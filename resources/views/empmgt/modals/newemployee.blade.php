<!-- Modal -->
                  <div class="modal fade modal-info" id="addUserForm" aria-hidden="false" aria-labelledby="addUserForm"
                  role="dialog" >
                    <div class="modal-dialog  modal-top modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="exampleFillInModalTitle">New Employee</h4>
                        </div>
                         <form id="addNewUserForm" method="POST">
                        <div class="modal-body">
                         @csrf
                            <div class="row">
                              <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="name">Name</label>
                                  <input type="text" class="form-control" id="name"  name="name" placeholder="Name"
                                   required />
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                               <div class="form-group " >
                                  <label class="form-control-label" for="emp_num">Employee Number</label>
                                  <input type="text" class="form-control" id="emp_num"  name="emp_num" placeholder="Employee Number"
                                   required />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="email">Email</label>
                                  <input type="email" class="form-control" id="email"  name="email" placeholder="Email"
                                    />
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                               <div class="form-group " >
                                  <label class="form-control-label" for="phone">Phone Number</label>
                                  <input type="text" class="form-control" id="phone"  name="phone" placeholder="Phone Number"
                                    />
                                </div>
                              </div>
                              </div>
                            <div class="row">
                               <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group " >
                                  <label class="form-control-label" for="sex">Gender</label>
                                  <select class="form-control" id="sex" name="sex" required>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group">
                                  <h4 class="example-title">Date of Birth</h4>
                                   <input type="text"   placeholder="Date of Birth" name="dob"   class="form-control datepicker">
                                </div>
                              </div>
                              </div>
                            <div class="row">
                                <div class="col-xs-12 col-xl-6 ">
                                    <div class="form-group " >
                                        <label class="form-control-label" for="grade">Cadre</label>
                                        <select id="cadre_id" name="cadre_id" onchange="cadreChange(this.value);" class="form-control select2"  style="width: 100%">
                                            <option></option>
                                            @foreach($cadres as $cadre)
                                                <option value="{{$cadre->id}}">{{$cadre->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-xl-6 form-group">
                                    <div class=" form-group">
                                        <div class="form-group " >
                                            <label class="form-control-label" for="ranks">Ranks</label>
                                            <select class="form-control select2" id="ranks" name="rank_id" required style="width: 100%">

                                                <option value="0">Please select cadre</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>


                              </div>
                            <div class="row">
                                <div class="col-xs-12 col-xl-6 ">
                                    <div class="form-group " >
                                        <label class="form-control-label" for="zone_id">Zones</label>
                                        <select id="zone_id" name="zone_id" onchange="zoneChange(this.value);" class="form-control select2"  style="width: 100%">
                                            <option></option>
                                            @foreach($zones as $zone)
                                                <option value="{{$zone->id}}">{{$zone->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-xl-6 form-group">
                                    <div class="form-group " >
                                        <label class="form-control-label" for="field_office_id">Field Office</label>
                                        <select class="form-control select2" id="field_offices"   name="field_office_id"  style="width: 100%">
                                            <option value="0">Please select zone</option>
                                        </select>
                                    </div>
                                </div>

                              </div>
                            <div class="row">
                                <div class="col-xs-12 col-xl-6 form-group">
                                    <div class="form-group " >
                                        <label class="form-control-label" for="department_id">Department</label>
                                        <select class="form-control select2" name="department_id"  required style="width: 100%">
                                            @forelse($ncompany->departments as $department)
                                                <option value="{{$department->id}}" >{{$department->name}}</option>
                                            @empty
                                                <option value="0">Please Create a department</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                               <div class="col-xs-12 col-xl-6 form-group">
                                <div class="form-group">
                                  <h4 class="example-title">Started</h4>
                                   <input type="text"  required placeholder="Started" name="started"   class="form-control datepicker">
                                </div>
                              </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="company_id" value="{{$ncompany->id}}">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal -->
