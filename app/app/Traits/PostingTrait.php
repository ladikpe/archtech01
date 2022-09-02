<?php


namespace App\Traits;



use App\Notifications\ApprovePosting;
use App\Notifications\PostingApproved;
use App\Notifications\PostingPassedStage;
use App\Notifications\PostingRejected;
use App\Stage;
use App\User;
use App\Workflow;
use Illuminate\Http\Request;
use App\Posting;
use App\PostingApproval;
use App\PostingType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait PostingTrait

{
    public function processGet($route,Request $request)
    {
        switch ($route) {
            case 'download':
                # code...
                return $this->download($request);
                break;
            

            case 'index':
                # code...
                return $this->postings($request);
                break;
            case 'my_postings':
                # code...
                return $this->my_postings($request);
                break;
            case 'posting':
                # code...
                return $this->posting($request);
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
            case 'posting_type':
                # code...
                return $this->posting_type($request);
                break;
            case 'delete_posting_type':
                # code...
                return $this->delete_posting_type($request);
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
            case 'save_posting':
                # code...
                return $this->save_posting($request);
                break;
            case 'save_posting_type':
                # code...
                return $this->save_posting_type($request);
                break;
            case 'save_posting_approval':
                # code...
                return $this->save_posting_approval($request);
                break;
            case 'upload_posting_file':
                # code...
                return $this->upload_posting_file($request);
                break;


            default:
                # code...
                break;
        }

    }

    public function postings(Request $request){
        $postings=Posting::all();
        $posting_types=PostingType::all();
        // $postings= Posting::whereHas('posting_type', function($query) use ($user){
        //     $query->whereHas('groups',function($query) use($user){
        //         $query->whereHas('users', function($query) use($user){
        //             $query->where('users.id',$user->id);
        //         });
        //     });
        // })->get();

        return view('postings.hrrequests',compact('postings','posting_types'));

    }
   
    public function posting(Request $request){
        return $posting=Posting::find($request->posting_id);

    }
    public function save_posting(Request $request){
        $pt=PostingType::find($request->posting_type_id);
        $workflow=$pt->workflow;
        if($pt->has_upload==1 && !$request->hasFile('requested_doc')){
            return 'no doc';
        }

        $posting=Posting::Create(['user_id'=>$request->user_id,'location'=>$request->location,'posting_type_id'=>$request->posting_type_id,'created_by'=>Auth::user()->id,'workflow_id'=>$workflow->id,'comment'=>$request->comment,'effective_date'=>date('Y-m-d',strtotime($request->effective_date))]);

        if ($request->file('requested_doc')) {

            $path = $request->file('requested_doc')->store('postings');
            if (Str::contains($path, 'postings')) {
                $filepath = Str::replaceFirst('postings', '', $path);
            } else {
                $filepath = $path;
            }
            // $posting=Posting::find($request->posting_id);
            $posting->file = $filepath;
            $posting->save();

            // $posting->user->notify(new PostingUploaded($posting));
        }
        $stage = Workflow::find($workflow->id)->stages->first();
        if ($stage->type == 1) {
            $posting->posting_approvals()->create([ 'stage_id' => $stage->id, 'comments' => '', 'status' => 0, 'approver_id' => $stage->user_id
            ]);
            if ($stage->user) {
                $stage->user->notify(new ApprovePosting($posting));
            }

        } elseif ($stage->type == 2) {
            $posting->posting_approvals()->create([ 'stage_id' => $stage->id, 'comments' => '', 'status' => 0, 'approver_id' => 0
            ]);
            if ($stage->role->manages == 'dr') {
                if ($posting->user->managers) {
                    foreach ($posting->user->managers as $manager) {
                        $manager->notify(new ApprovePosting($posting));
                    }
                }
            } elseif ($stage->role->manage == 'all') {
                foreach ($stage->role->users as $user) {
                    $user->notify(new ApprovePosting($posting));
                }
            } elseif ($stage->role->manage == 'none') {
                foreach ($stage->role->users as $user) {
                    $user->notify(new ApprovePosting($posting));
                }
            }
        } elseif ($stage->type == 3) {
            $posting->posting_approvals()->create([ 'stage_id' => $stage->id, 'comments' => '', 'status' => 0, 'approver_id' => 0
            ]);
            if ($stage->group) {
                foreach ($stage->group->users as $user) {
                    $user->notify(new ApprovePosting($posting));
                }
            }

        }
        return 'success';
    }


    // public function upload_posting_file(Request $request){

    //     if ($request->file('requested_doc')) {

    //         $path = $request->file('requested_doc')->store('postings');
    //         if (Str::contains($path, 'postings')) {
    //             $filepath = Str::replaceFirst('postings', '', $path);
    //         } else {
    //             $filepath = $path;
    //         }
    //         $posting=Posting::find($request->posting_id);
    //         $posting->file = $filepath;
    //         $posting->save();

    //         $posting->user->notify(new PostingUploaded($posting));
    //     }

    //     return redirect()->back();

    // }
    public function approvals(Request $request)
    {
        $user = Auth::user();

        $user_approvals = $this->userApprovals($user);
        $dr_approvals = $this->getDRPostingApprovals($user);
        $role_approvals = $this->roleApprovals($user);
        $group_approvals = $this->groupApprovals($user);

        return view('postings.approvals', compact('user_approvals', 'role_approvals', 'group_approvals', 'dr_approvals'));
    }

    // public function departmentApprovals(Request $request)
    // {
    //     $user = Auth::user();
    //     $dapprovals = PostingApproval::whereHas('posting.user.job.department', function ($query) use ($user) {
    //         $query->where('postings.user_id', '!=', $user->id)
    //             ->where('departments.manager_id', $user->id);

    //     })
    //         ->where('status', 0)->orderBy('id', 'asc')->get();
    //     return view('postings.department_approvals', compact('dapprovals'));
    // }

    public function userApprovals(User $user)
    {
        return $las = PostingApproval::whereHas('stage.user', function ($query) use ($user) {
            $query->where('users.id', $user->id);

        })
            ->where('status', 0)->orderBy('id', 'asc')->get();

    }

    public function getDRPostingApprovals(User $user)
    {
        return Auth::user()->getDRPostingApprovals();
        // 	return $las = LeaveApproval::whereHas('stage.role.users',function($query) use($user){
        // 	$query->where('users.id',$user->id);
        // })

        //  ->where('status',0)->orderBy('id','desc')->get();

    }

    public function roleApprovals(User $user)
    {
        return $las = PostingApproval::whereHas('stage.role', function ($query) use ($user) {
            $query->where('manages', '!=', 'dr')
                ->where('roles.id', $user->role_id);
        })->where('status', 0)->orderBy('id', 'asc')->get();
    }

    public function groupApprovals(User $user)
    {
        return $las = PostingApproval::whereHas('stage.group.users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
            ->where('status', 0)->orderBy('id', 'asc')->get();

    }

    public function save_posting_approval(Request $request)
    {
        $posting_approval = PostingApproval::find($request->posting_approval_id);
        $posting_approval->comments = $request->comment;
        if ($request->approval == 1) {
            $posting_approval->status = 1;
            $posting_approval->approver_id = Auth::user()->id;
            $posting_approval->save();
            // $logmsg=$leave_approval->document->filename.' was approved in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
            // $this->saveLog('info','App\Review',$leave_approval->id,'document_approvals',$logmsg,Auth::user()->id);
            $newposition = $posting_approval->stage->position + 1;
            $nextstage = Stage::where(['workflow_id' => $posting_approval->stage->workflow->id, 'position' => $newposition])->first();
            // return $review->stage->position+1;
            // return $nextstage;

            if ($nextstage) {

                $newposting_approval = new PostingApproval();
                $newposting_approval->stage_id = $nextstage->id;
                $newposting_approval->posting_id = $posting_approval->posting->id;
                $newposting_approval->status = 0;
                $newposting_approval->save();
                // $logmsg='New review process started for '.$newleave_approval->document->filename.' in the '.$newleave_approval->stage->workflow->name;
                // $this->saveLog('info','App\Review',$leave_approval->id,'reviews',$logmsg,Auth::user()->id);
                if ($nextstage->type == 1) {

                    // return $nextstage->type . '-2--' . 'all';

                    $nextstage->user->notify(new ApprovePosting($newposting_approval->posting));
                } elseif ($nextstage->type == 2) {
                    // return $nextstage->role->manages . '1---' . 'all' . json_encode($leave_approval->leave_request->user->managers);
                    if ($nextstage->role->manages == 'dr') {

                        // return $nextstage->role->manage . '---' . json_encode($nextstage->role->users);

                        foreach ($posting_approval->posting->user->managers as $manager) {
                            $manager->notify(new ApprovePosting($newposting_approval->posting));
                        }
                    } elseif ($nextstage->role->manages == 'all') {
                        // return 'all.';

                        // return $nextstage->role->manage . '---' . json_encode($nextstage->role->users);

                        foreach ($nextstage->role->users as $user) {
                            $user->notify(new ApprovePosting($newposting_approval->posting));
                        }
                    } elseif ($nextstage->role->manage == 'none') {
                        foreach ($nextstage->role->users as $user) {
                            $user->notify(new ApprovePosting($newposting_approval->posting));
                        }
                    }
                } elseif ($nextstage->type == 3) {
                    //1-user
                    //2-role
                    //3-groups
                    // return 'not_blank';

                    foreach ($nextstage->group->users as $user) {
                        $user->notify(new ApprovePosting($newposting_approval->posting));
                    }
                } else {
                    // return 'blank';
                }

                $posting_approval->posting->creator->notify(new PostingPassedStage($posting_approval, $posting_approval->stage, $newposting_approval->stage));
            } else {
                // return 'blank2';
                $posting_approval->posting->approval_status = 1;
                $posting_approval->posting->save();

                $posting_approval->posting->creator->notify(new PostingApproved($posting_approval->stage, $posting_approval));
            }


        } elseif ($request->approval == 2) {
            // return 'blank3';
            $posting_approval->status = 2;
            $posting_approval->comments = $request->comment;
            $posting_approval->approver_id = Auth::user()->id;
            $posting_approval->save();
            // $logmsg=$leave_approval->document->filename.' was rejected in the '.$leave_approval->stage->name.' in the '.$leave_approval->stage->workflow->name;
            // $this->saveLog('info','App\Review',$leave_approval->id,'document_approvals',$logmsg,Auth::user()->id);
            $posting_approval->posting->approval_status = 2;
            $posting_approval->posting->save();
            $posting_approval->posting->creator->notify(new PostingRejected($posting_approval->stage, $posting_approval));
            // return redirect()->route('documents.mypendingdocument_approvals')->with(['success'=>'Document Reviewed Successfully']);
        }

        return 'success';


        // return redirect()->route('documents.mypendingreviews')->with(['success'=>'Leave Request Approved Successfully']);
    }

    public function settings(Request $request){
        $posting_types=PostingType::all();
        $workflows=Workflow::where('status',1)->get();

        return view('settings.postingsettings.index',compact('posting_types','workflows'));
    }
    public function posting_type(Request $request){

        return $posting_type=PostingType::where('id',$request->posting_type_id)->first();
    }
    public function delete_posting_type(Request $request){
        $posting_type=PostingType::find($request->posting_type_id);
        if ($posting_type->postings->count()>1){
            return 'error';
        }else{
            
            $posting_type->delete();
            return 'success';
        }
    }
    public function save_posting_type(Request $request){
        

        

        $drt=PostingType::updateOrCreate(['id'=>$request->posting_type_id],['name'=>$request->name,'workflow_id'=>$request->workflow_id,'created_by'=>Auth::user()->id,'has_upload'=>$request->has_upload]);
       
        return 'success';
    }
    public function getDetails(Request $request)
    {
        $posting = Posting::where('id', $request->posting_id)->first();
        return view('postings.partials.posting_details', compact('posting'));
    }
    private function download(Request $request)
    {


        $posting = Posting::find($request->posting_id);
        if ($posting->file != '') {
            $path = $posting->file;

            return response()->download(public_path('uploads/postings' . $path));
        } else {
            redirect()->back();
        }
    }
    



}
