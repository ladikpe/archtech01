@extends('layouts.master')
@section('stylesheets')
@endsection


@section('script-footer')



@endsection

@section('content')


    <!-- Page -->
    <div class="page ">

        {{--<div class="page-header" style="padding-bottom: 0;">--}}
        {{--<h1 class="page-title">Course Trainings</h1>--}}
        {{--</div>--}}


        <div class="page-content container-fluid" style="padding-top: 29px;">



            <div id="outlet" class="row" style="background-color: #fff;padding: 11px;border-top: 2px solid #03a9f4;">



               @include('training_new.man_power.request_module')

               @include('training_new.man_power.approval_module')


            </div>



        </div>

    </div>
    <!-- End Page -->
@endsection

@section('scripts')

<script type="text/html" id="approval-reuse">

    <table id="tbl" class="table">
        <tr>
            <th>
                Stage
            </th>
            <th>
                Status
            </th>
            <th>
                Approved By
            </th>
            <th>
                Date Approved
            </th>
            <th>
                Actions
            </th>
        </tr>
    </table>

</script>

    @include('training_new.man_power.js')

{{--    <script src="{{ asset('js/components/ui.js') }}"></script>--}}

    <script>

        $('[data-users]').selectData({
            url:'{{ route('man_power_training.show',['fetch-users']) }}',
            key:'id',
            label:'name'
        });

        //create-manpower
        //update-manpower
        ////study_type

        $('#update-manpower,#create-manpower').each(function(){
            var $withpay = $(this).find('#withpay');
            $(this).find('#study_type').on('change',function(){

                console.log('triggered change',$(this).val());

                $withpay.hide();

                if ($(this).val() == 'fulltime'){
                  $withpay.show();
                }

            });
            $(this).find('#study_type').trigger('change');
        });


        var $manPower = $('#man-power-module').crudTable({

            fetchUrl:function(){
                return '{{ route('man_power_training.show',['fetch']) }}';
            },
            createUrl:function(){
                return '{{ route('man_power_training.store') }}';
            },
            updateUrl:function(data){
                return `{{ route('man_power_training.update',['']) }}/${data.id}`;
            },
            deleteUrl:function(data){
                return `{{ route('man_power_training.destroy',['']) }}/${data.id}`;
            },
            createModalFormSelector:'#create-manpower',
            editModalFormSelector:'#update-manpower',
            onAppendRow:function(data){
                return `<tr>
                        <td>
                           ${data.name_of_institution}
                        </td>
                        <td>
                           ${data.total_cost_of_training}
                        </td>
                        <td>
                           ${data.study_type}
                        </td>
                        <td>
                           ${data.date_of_training}
                        </td>
                        <td>
                           ${data.status == 1? 'Approved':'Pending'}
                        </td>
                        <td>
                            <a class="btn btn-sm btn-info" href="#" id="detail">Detail</a>
                            <a class="btn btn-sm btn-success" href="#" id="approvals">Approvals</a>
                            <a class="btn btn-sm btn-danger" href="#" id="remove">Remove</a>
                        </td>
                    </tr>`;
            },
            onSelectRow:function($el,data,openEditRecord,removeRecord){

                $el.find('#detail').on('click',function(){
                    openEditRecord();
                    console.log(data);
                    return false;
                });

                $el.find('#remove').on('click',function(){
                    if (confirm("Do you want to remove this record?")){
                        removeRecord();
                    }
                    return false;
                });

                $el.find('#approvals').on('click',function(){
                    $('#man-power-approval-module').modal();
                    $('#approval-reuse').useTemplate().mount('#man-power-approval-module-inner');
                    initApprovalModal('#man-power-approval-module-inner',data);
                });

            },
            onFillForm:function($formEl,data){

                var $el = $formEl.find('#approval-outlet');
                $('#approval-reuse').useTemplate().mount($el);
                initApprovalModal($el,data);

            }

        });


        var $approval = null;
        //useTemplate
        function initApprovalModal(sel,$data){


            if ($approval !== null){
                //$approval.setFetchUrl(`{{ route('man_power_training_approval.index') }}?id=${$data.id}`);
                //return;
            }

            $approval = $(sel).crudTable({


                fetchUrl:function(){
                    return `{{ route('man_power_training_approval.index') }}?id=${$data.id}`;
                },
                updateUrl:function(data){
                    return `{{ route('man_power_training_approval.update',['']) }}/${data.id}`;
                },
                editModalFormSelector:'#update-manpower-approval',
                onAppendRow:function(data){
                    return `<tr>
                                <td>
                                    ${data.stage.name}
                                </td>
                                <td>
                                    ${data.status}
                                </td>
                                <td>
                                    ${(data.approver)? data.approver.name : 'Pending'}
                                </td>
                                <td>
                                    ${(data.status == 1)? data.created_at : 'Pending'}
                                </td>
                                <td>
                                    <a id="approve" href="#" class="btn btn-sm btn-success">Confirm Approval</a>
                                    <b id="passed" style="color:green;">Passed</b>
                                </td>
                            </tr>`;
                },
                onSelectRow:function($el,data,openEditModal,removeRecord){

                    $el.find('#passed').hide();

                    $el.find('#approve,#passed').on('click',function(){
                        openEditModal();
                        return false;
                    });

                    if (data.approver != null && data.status == 1){
                        $el.find('#approve').hide();
                    }

                    if (data.status){
                        $el.find('#passed').show();
                    }

                    if (!data.can_approve){
                        $el.find('#approve').hide();
                    }



                },
                onFillForm:function($formEl,data){
                    if (data.status == 1){
                        $formEl.find('#submit-approval').hide();
                    }
                },
                onAjaxFinished:function(){
                    $manPower.refresh();
                }

            });

        }


    </script>

@endsection