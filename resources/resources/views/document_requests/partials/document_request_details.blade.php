
<ul class="list-group list-group-bordered mb-0">
              <li class="list-group-item list-group-item-dark">
                               Details
              </li>
              <li class="list-group-item">
                              <strong>Title:</strong>  {{$document_request->title}}
              </li>
              <li class="list-group-item">
                              Requestor:  {{$document_request->user?$document_request->user->name:''}}
              </li>
              <li class="list-group-item">
                              Document Type:  {{$document_request->document_request_type?$document_request->document_request_type->name:''}}
              </li>
              <li class="list-group-item">
                              Requested on:  {{date("F j, Y",strtotime($document_request->created_at))}}
              </li>
             <li class="list-group-item">
                              Due Date :  {{date("F j, Y",strtotime($document_request->due_date))}}
              </li>
            </ul>
<ul class="list-group list-group-bordered mb-0">
              <li class="list-group-item list-group-item-dark">
                               Files
              </li>
              <li class="list-group-item">
                       Employee File:       @if($document_request->employee_file!='')
                  <a style="cursor:pointer;"class="btn btn-primary btn-sm" id="" target="_blank" href="{{url('document_requests/employee_download?document_request_id='.$document_request->id)}}"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Download Document</a>
                  @else
                  File was not uploaded
                  @endif
              </li>
              <li class="list-group-item">
                       Uploaded File:         @if($document_request->file!='')
                  <a style="cursor:pointer;"class="btn btn-primary btn-sm" id="" target="_blank" href="{{url('document_requests/download?document_request_id='.$document_request->id)}}"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Download Document</a>
                  @else
                  File was not uploaded
                  @endif
              </li>
             
            </ul>
<ul class="list-group list-group-bordered mb-0">
              <li class="list-group-item list-group-item-dark">
                               Employee Comment/Reason
              </li>
              <li class="list-group-item">
                               {{$document_request->comment}}
              </li>
             
            </ul>
<div class="table-responsive">
	<h4>Approval Details ({{$document_request->workflow->name}})</h4>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Stage</th>
			<th>Approved By</th>
			<th>Approved At</th>
			<th>Comment</th>
			<th>Status</th>
			<th>Time in Stage</th>

		</tr>
	</thead>
	<tbody>
		@foreach($document_request->document_approvals as $approval)
		<tr>
			<td>{{$approval->stage->name}}</td>
			<td>{{$approval->approver_id>0?$approval->approver->name:""}}</td>
			<td>{{date("F j, Y",strtotime($approval->created_at))}}</td>
			<td>{{$approval->comments}}</td>
			<td><span class=" tag   {{$approval->status==0?'tag-warning':($approval->status==1?'tag-success':'tag-danger')}}">{{$approval->status==0?'pending':($approval->status==1?'approved':'rejected')}}</span></td>
			<td>{{ $approval->created_at==$approval->updated_at?\Carbon\Carbon::parse($approval->created_at)->diffForHumans():\Carbon\Carbon::parse($approval->created_at)->diffForHumans(Carbon\Carbon::parse($approval->updated_at),true,false,5) }}</td>
			
		</tr>
		@endforeach
	</tbody>

</table>
</div
