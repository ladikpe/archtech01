<div class="panel panel-info panel-line">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $rank->name }} <b>Grade:</b> {{ $rank->grade->level }} <b>Cadre:</b> {{ $rank->cadre->name }} <b>Year:</b>{{ $year }}</h3>
        @if($year==\Carbon\Carbon::today()->format('Y'))
            <div class="panel-actions">
                @if($type=='exam')
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline btn-info dropdown-toggle" id="exampleGroupDrop2" data-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="exampleGroupDrop2" role="menu">
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem"  data-toggle="modal" data-target="#uploadResultModal"> Import Exam Scores With Excel</a>
                            <a class="dropdown-item" href="{{ route('export.promotion.details') }}?year={{$year}}" role="menuitem">Export as Excel</a>
                        </div>
                    </div>
            @endif
                <button class="btn btn-success" type="button" onclick="confirmApprove()">
                    Recommend
                </button>
            </div>
        @endif
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="expandDataTable" class="display nowrap">
                <thead>
                <tr>
                    <th>Select</th>
                    <th>More</th>
                    <th>Name</th>
                    <th>State</th>
                    {{-- <th>DOB</th>
                   <th>First Appt</th>
                    <th>Confirmation</th>
                    <th>Present Appt</th>
                    <th>Cadre</th>
                    <th>GL</th>--}}
                    <th>Present Appointment</th>
                    <th> Post Considered for</th>
                    @if($type=='exam')
                    <th>APER (20)</th>
                    <th>Seniority (10)</th>
                    <th>Profession Exam Score (30)</th>
                    <th>Civil Service Exam Score (30)</th>
                    <th>General Paper Exam Score (10)</th>
                    <th><b>Total</b></th>
                    <th>Exam Number</th>
                    <th>Tries</th>
                    @endif
                    <th>Status</th>
                </tr>
                </thead>
                <tbody  id="directempsbody">
                @forelse($promotions as $promotion)
                    <tr data-child-value="{{ $promotion }}">
                        <td>
                            @if($promotion->status=='pass')
                                <span class="checkbox-success checkbox-sm">
                                  <input type="checkbox" class="contacts-checkbox users-checkbox selectable-item" id="{{$promotion->id}}"/>
                                  <label for="contacts_1"></label>
                                </span>
                            @else
                                Can't recommend
                            @endif
                        </td>
                        <td class="details-control"></td>
                        <td>{{$promotion->user->name}}</td>
                        <td>{{$promotion->state}} </td>
                        {{--<td>{{$promotion->dob}} </td>
                        <td>{{$promotion->first_appointment}} </td>
                        <td>{{$promotion->date_of_confirmation}} </td>
                        <td>{{$promotion->present_appointment}} </td>
                        <td>{{$promotion->oldrank->cadre->name}} </td>
                        <td>{{$promotion->oldrank->grade->level}} </td>--}}
                        <td>{{$promotion->oldrank->name}} </td>
                        <td>{{$promotion->newrank->name}} </td>
                        @if($type=='exam')
                        <td>{{$promotion->aper_score}}</td>
                        <td>{{$promotion->seniority_score}}</td>
                         <td>{{$promotion->profession_exam_score}}</td>
                        <td>{{$promotion->civil_service_exam_score}}</td>
                        <td>{{$promotion->general_paper_exam_score}}</td>
                        <td>{{$promotion->exam_score+$promotion->seniority_score+$promotion->aper_score}}</td>
                        <td>{{$promotion->exam_number}}</td>
                        <td>{{$promotion->tries}}</td>
                        @endif
                        <td>
                            @if($promotion->status=='pending')
                                <span class="text-warning">{{ $promotion->status }}</span>
                            @elseif($promotion->status=='pass')
                                <span class="text-success"> {{ $promotion->status }}</span>
                            @elseif($promotion->status=='fail')
                                <span class="text-danger"> {{ $promotion->status }}</span>
                            @else
                                <span class="tex-primary"> {{ $promotion->status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="text-align: center">
                            <h3 style="">No Promotion List for this year.</h3>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function format(value) {
        return '<div>' +
            '<b>First Appointment:</b> ' + value.first_appointment + ' <br>' +
            '<b>Date of Confirmation:</b> ' + value.date_of_confirmation + ' <br>' +
            '<b>Present Appointment:</b> ' + value.present_appointment + ' <br>' +
            '<b>DOB:</b> ' + value.dob + ' <br>' +
            '<b>Cadre:</b> ' + value.oldrank.cadre.name + ' <br>' +
            '<b>Grade Level:</b> ' + value.oldrank.grade.level + ' <br>' +
            ' </div>';
    }
    $(document).ready(function () {
        var table = $('#expandDataTable').DataTable({});

        // Add event listener for opening and closing details
        table.on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(tr.data('child-value'))).show();
                tr.addClass('shown');
            }
        });
    });
</script>

<script>
    function  approve() {
         var pendings = $(".users-checkbox:checkbox:checked").map(function(){
             if (this.checked === true) {
                 return this.id;
             }
         }).toArray();
         if (pendings.length<1){
             toastr.error('Select at least a Staff');
         }
         else{
            var token = '{{csrf_token()}}';
             senddata={'_token':token,'promotions':pendings};
            console.log(senddata);
            $.ajax({
                url: '{{route('approve.promotions')}}',
                type: 'POST',
                data: senddata,
                success: function (data, textStatus, jqXHR) {
                    toastr.success('Successfully Approved Promotion');
                    console.log(data)
                  /*  setTimeout(function () {
                        window.location.reload();
                    }, 2000);*/
                },
                error: function (data, textStatus, jqXHR) {

                }
            });
         }

    }

    function confirmApprove() {
        var txt;
        var r = confirm("Are you sure you want to approve the staff that passed Promotions?");
        if (r == true) {
            approve()
        } else {
            toastr.error('It was not approved');
        }
    }
</script>