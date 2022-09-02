<?php


namespace App\Traits;



use App\Notifications\ApproveDocumentRequest;
use App\Notifications\DocumentRequestApproved;
use App\Notifications\DocumentRequestPassedStage;
use App\Notifications\DocumentRequestRejected;
use App\Notifications\DocumentRequestUploaded;
use App\Stage;
use App\User;
use App\Workflow;
use Illuminate\Http\Request;
use App\DocumentRequest;
use App\DocumentRequestApproval;
use App\DocumentRequestType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait DocumentRequestTrait

{
    public function processGet($route,Request $request)
    {
        switch ($route) {
            case 'download':
                # code...
                return $this->download($request);
                break;
                case 'employee_download':
                # code...
                return $this->employee_download($request);
                break;
                
            case 'index':
                # code...
                return $this->document_requests($request);
                break;
            case 'my_document_requests':
                # code...
                return $this->my_document_requests($request);
                break;
            case 'document_request':
                # code...
                return $this->document_request($request);
                break;
            case 'approvals':
                # code...
                return $this->approvals($request);
                break;
            case 'department_approvals':
                # code...
                return $this->departmentApprovals($request);
                break;
            case 'settings':
                # code...
                return $this->settings($request);
                break;
            case 'document_request_type':
                # code...
                return $this->document_request_type($request);
                break;
            case 'delete_document_request_type':
                # code...
                return $this->delete_document_request_type($request);
                break;
            case 'get_details':
                # code...
                return $this->getDetails($request);
                break;


            default:
                # code...
                break;

        }
    }

    public function processPost(Request $request){
        // try{
        switch ($request->type) {
            case 'save_document_request':
                # code...
                return $this->save_document_request($request);
                break;
            case 'save_document_request_type':
                # code...
                return $this->save_document_request_type($request);
                break;
            case 'save_document_request_approval':
                # code...
                return $this->save_document_request_approval($request);
                break;
            case 'upload_document_request_file':
                # code...
                return $this->upload_document_request_file($request);
                break;


            default:
                # code...
                break;
        }

    }

    public function document_requests(Request $request){
        // $document_requests=DocumentRequest::all();
        $user=Auth::user();
         $document_requests= DocumentRequest::whereHas('document_request_type', function($query) use ($user){
            $query->whereHas('groups',function($query) use($user){
              $query->whereHas('users', function($query) use($user){
                  $query->where('users.id',$user->id);
             });
          });
        })->get();

        return view('document_requests.hrrequests',compact('document_requests'));

    }
    public function my_document_requests(Request $request){
        $document_requests=DocumentRequest::where('user_id',Auth::user()->id)->get();
        $document_request_types=DocumentRequestType::all();

        return view('document_requests.myrequests',compact('document_requests','document_request_types'));

    }
    public function document_request(Request $request){
        return $document_request=DocumentRequest::find($request->document_request_id);

    }
    public function save_document_request(Request $request){
        $drt=DocumentRequestType::find($request->document_request_type_id);
        $workflow=$drt->workflow;
        if($drt->has_upload==1 && !$request->hasFile('requested_doc')){
            return 'no doc';
        }
        
        $document_request=DocumentRequest::Create(['title'=>$request->title,'document_request_type_id'=>$request->document_request_type_id,'user_id'=>Auth::user()->id,'workflow_id'=>$workflow->id,'company_id'=>companyId(),'comment'=>$request->comment,'due_date'=>date('Y-m-d',strtotime($request->due_date))]);
        
        if ($request->file('requested_doc')) {

            $path = $request->file('requested_doc')->store('document_requests');
            if (Str::contains($path, 'document_requests')) {
                $filepath = Str::replaceFirst('document_requests', '', $path);
            } else {
                $filepath = $path;
            }
           
            $document_request->employee_file = $filepath;
            $document_request->save();

            // $document_request->user->notify(new DocumentRequestUploaded($document_request));
        }
        $stage = Workflow::find($workflow->id)->stages->first();
        if ($stage->type == 1) {
            $document_request->document_approvals()->create([ 'stage_id' => $stage->id, 'comments' => '', 'status' => 0, 'approver_id' => $stage->user_id
            ]);
            if ($stage->user) {
                $stage->user->notify(new ApproveDocumentRequest($document_request));
            }

        } elseif ($stage->type == 2) {
            $document_request->document_approvals()->create([ 'stage_id' => $stage->id, 'comments' => '', 'status' => 0, 'approver_id' => 0
            ]);
            if ($stage->role->manages == 'dr') {
                if ($document_request->user->managers) {
                    foreach ($document_request->user->managers as $manager) {
                        $manager->notify(new ApproveDocumentRequest($document_request));
                    }
                }
            } elseif ($stage->role->manage == 'all') {
                foreach ($stage->role->users as $user) {
                    $user->notify(new ApproveDocumentRequest($document_request));
                }
            } elseif ($stage->role->manage == 'none') {
                foreach ($stage->role->users as $user) {
                    $user->notify(new ApproveDocumentRequest($document_request));
                }
            }
        } elseif ($stage->type == 3) {
            $document_request->document_approvals()->create([ 'stage_id' => $stage->id, 'comments' => '', 'status' => 0, 'approver_id' => 0
            ]);
            if ($stage->group) {
                foreach ($stage->group->users as $user) {
                    $user->notify(new ApproveDocumentRequest($document_request));
                }
            }

        }
        return 'success';
    }


    public function upload_document_request_file(Request $request){

        if ($request->file('requested_doc')) {

            $path = $request->file('requested_doc')->store('document_requests');
            if (Str::contains($path, 'document_requests')) {
                $filepath = Str::replaceFirst('document_requests', '', $path);
            } else {
                $filepath = $path;
            }
            $document_request=DocumentRequest::find($request->document_request_id);
            $document_request->file = $filepath;
            $document_request->save();

            $document_request->user->notify(new DocumentRequestUploaded($document_request));
        }

        return redirect()->back();

    }
    public function approvals(Request $request)
    {
        $user = Auth::user();

        $user_approvals = $this->userApprovals($user);
        $dr_approvals = $this->getDRDocumentRequestApprovals($user);
        $role_approvals = $this->roleApprovals($user);
        $group_approvals = $this->groupApprovals($user);

        return view('document_requests.approvals', compact('user_approvals', 'role_approvals', 'group_approvals', 'dr_approvals'));
    }

    public function departmentApprovals(Request $request)
    {
        $user = Auth::user();
        $dapprovals = DocumentRequestApproval::whereHas('document_request.user.job.department', function ($query) use ($user) {
            $query->where('document_requests.user_id', '!=', $user->id)
                ->where('departments.manager_id', $user->id);

        })
            ->where('status', 0)->orderBy('id', 'asc')->get();
        return view('document_requests.department_approvals', compact('dapprovals'));
    }

    public function userApprovals(User $user)
    {
        return $las = DocumentRequestApproval::whereHas('stage.user', function ($query) use ($user) {
            $query->where('users.id', $user->id);

        })
            ->where('status', 0)->orderBy('id', 'asc')->get();

    }

    public function getDRDocumentRequestApprovals(User $user)
    {
        return Auth::user()->getDRDocumentRequestApprovals();
        // 	return $las = LeaveApproval::whereHas('stage.role.users',function($query) use($user){
        // 	$query->where('users.id',$user->id);
        // })

        //  ->where('status',0)->orderBy('id','desc')->get();

    }

    public function roleApprovals(User $user)
    {
        return $las = DocumentRequestApproval::whereHas('stage.role', function ($query) use ($user) {
            $query->where('manages', '!=', 'dr')
                ->where('roles.id', $user->role_id);
        })->where('status', 0)->orderBy('id', 'asc')->get();
    }

    public function groupApprovals(User $user)
    {
        return $las = DocumentRequestApproval::whereHas('stage.group.users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
            ->where('status', 0)->orderBy('id', 'asc')->get();

    }

    public function save_document_request_approval(Request $request)
    {
        $document_request_approval = DocumentRequestApproval::find($request->document_request_approval_id);
        $document_request_approval->comments = $request->comment;
        if ($request->approval == 1) {
            $document_request_approval->status = 1;
            $document_request_approval->approver_id = Auth::user()->id;
            $document_request_approval->save();
            // $logmsg=$leave_approval->document->filename.' was approved in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
            // $this->saveLog('info','App\Review',$leave_approval->id,'document_approvals',$logmsg,Auth::user()->id);
            $newposition = $document_request_approval->stage->position + 1;
            $nextstage = Stage::where(['workflow_id' => $document_request_approval->stage->workflow->id, 'position' => $newposition])->first();
            // return $review->stage->position+1;
            // return $nextstage;

            if ($nextstage) {

                $newdocument_request_approval = new DocumentRequestApproval();
                $newdocument_request_approval->stage_id = $nextstage->id;
                $newdocument_request_approval->document_request_id = $document_request_approval->document_request->id;
                $newdocument_request_approval->status = 0;
                $newdocument_request_approval->save();
                // $logmsg='New review process started for '.$newleave_approval->document->filename.' in the '.$newleave_approval->stage->workflow->name;
                // $this->saveLog('info','App\Review',$leave_approval->id,'reviews',$logmsg,Auth::user()->id);
                if ($nextstage->type == 1) {

                    // return $nextstage->type . '-2--' . 'all';

                    $nextstage->user->notify(new ApproveDocumentRequest($newdocument_request_approval->document_request));
                } elseif ($nextstage->type == 2) {
                    // return $nextstage->role->manages . '1---' . 'all' . json_encode($leave_approval->leave_request->user->managers);
                    if ($nextstage->role->manages == 'dr') {

                        // return $nextstage->role->manage . '---' . json_encode($nextstage->role->users);

                        foreach ($document_request_approval->document_request->user->managers as $manager) {
                            $manager->notify(new ApproveDocumentRequest($newdocument_request_approval->document_request));
                        }
                    } elseif ($nextstage->role->manages == 'all') {
                        // return 'all.';

                        // return $nextstage->role->manage . '---' . json_encode($nextstage->role->users);

                        foreach ($nextstage->role->users as $user) {
                            $user->notify(new ApproveDocumentRequest($newdocument_request_approval->document_request));
                        }
                    } elseif ($nextstage->role->manage == 'none') {
                        foreach ($nextstage->role->users as $user) {
                            $user->notify(new ApproveDocumentRequest($newdocument_request_approval->document_request));
                        }
                    }
                } elseif ($nextstage->type == 3) {
                    //1-user
                    //2-role
                    //3-groups
                    // return 'not_blank';

                    foreach ($nextstage->group->users as $user) {
                        $user->notify(new ApproveDocumentRequest($newdocument_request_approval->document_request));
                    }
                } else {
                    // return 'blank';
                }

                $document_request_approval->document_request->user->notify(new DocumentRequestPassedStage($document_request_approval, $document_request_approval->stage, $newdocument_request_approval->stage));
            } else {
                // return 'blank2';
                $document_request_approval->document_request->status = 1;
                $document_request_approval->document_request->save();

                $document_request_approval->document_request->user->notify(new DocumentRequestApproved($document_request_approval->stage, $document_request_approval));
            }


        } elseif ($request->approval == 2) {
            // return 'blank3';
            $document_request_approval->status = 2;
            $document_request_approval->comments = $request->comment;
            $document_request_approval->approver_id = Auth::user()->id;
            $document_request_approval->save();
            // $logmsg=$leave_approval->document->filename.' was rejected in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
            // $this->saveLog('info','App\Review',$leave_approval->id,'document_approvals',$logmsg,Auth::user()->id);
            $document_request_approval->document_request->status = 2;
            $document_request_approval->document_request->save();
            $document_request_approval->document_request->user->notify(new DocumentRequestRejected($document_request_approval->stage, $document_request_approval));
            // return redirect()->route('documents.mypendingdocument_approvals')->with(['success'=>'Document Reviewed Successfully']);
        }

        return 'success';


        // return redirect()->route('documents.mypendingreviews')->with(['success'=>'Leave Request Approved Successfully']);
    }

    public function settings(Request $request){
        $document_request_types=DocumentRequestType::all();
        $workflows=Workflow::where('status',1)->get();
        $groups=\App\UserGroup::all();

        return view('settings.documentrequestsettings.index',compact('document_request_types','workflows','groups'));
    }
    public function document_request_type(Request $request){
        
        return $document_type=DocumentRequestType::where('id',$request->document_request_type_id)->with('groups')->first();
    }
public function delete_document_request_type(Request $request){
    $document_type=DocumentRequestType::find($request->document_request_type_id);
    if ($document_type->document_requests->count()>1){
        return 'error';
    }else{
         $document_type->groups()->detach();
        $document_type->delete();
        return 'success';
    }
}
    public function save_document_request_type(Request $request){
        $no_of_groups=0;

        if($request->filled('group_id')){
            $no_of_groups=count($request->input('group_id'));
        }
        
        $drt=DocumentRequestType::updateOrCreate(['id'=>$request->document_request_type_id],['name'=>$request->name,'workflow_id'=>$request->workflow_id,'created_by'=>Auth::user()->id,'has_upload'=>$request->has_upload]);
         $drt->groups()->detach();
        if($no_of_groups>0){
          for ($i=0; $i <$no_of_groups ; $i++) {
            $drt->groups()->attach($request->group_id[$i],['created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            
          }
          }
        return 'success';
    }
    public function getDetails(Request $request)
    {
        $document_request = DocumentRequest::where('id', $request->document_request_id)->first();
        return view('document_requests.partials.document_request_details', compact('document_request'));
    }
    private function download(Request $request)
    {


        $document_request = DocumentRequest::find($request->document_request_id);
        if ($document_request->file != '') {
            $path = $document_request->file;

            return response()->download(public_path('uploads/document_requests' . $path));
        } else {
            redirect()->back();
        }
    }
    private function employee_download(Request $request)
    {


        $document_request = DocumentRequest::find($request->document_request_id);
        if ($document_request->employee_file != '') {
            $path = $document_request->employee_file;

            return response()->download(public_path('uploads/document_requests' . $path));
        } else {
            redirect()->back();
        }
    }




}
