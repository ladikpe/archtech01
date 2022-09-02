<?php


namespace App\Traits;



use App\AperAssessment;
use App\AperAssessmentDetail;
use App\AperMetric;
use App\AperPerformanceDiscussion;
use App\AperSubMetric;
use App\AperMeasurementPeriod;

use App\Notifications\NotifyHrSavePerformanceDiscussion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait AperTrait

{
    public function processGet($route,Request $request)
    {
        switch ($route) {
            case 'get_hr_evaluation':
                # code...
                return $this->hr_evaluations($request);
                break;
            case 'get_hr_user_list':
                # code...
                return $this->getHRUserList($request);
                break;
            case 'get_hr_user_promotion_list':
                # code...
                return $this->getHRUserPromotionEvaluatedList($request);
                break;

            case 'get_line_manager_user_list':
                # code...
                return $this->getEvaluationUserList($request);
                break;
            case 'get_evaluation':
                # code...
                return $this->getEvaluation($request);
                break;
            case 'get_evaluation_assessments_preview':
                # code...
                return $this->get_evaluation_assessments_preview($request);
                break;
            case 'export_assessment_pdf':
                # code...
                return $this->export_assessment_pdf($request);
                break;

             case 'export_assessment_excel':
                 # code...
                 return $this->export_assessment_excel($request);
                 break;
            case 'get_employee_evaluation_assessments':
                # code...
                return $this->get_employee_evaluation_assessments($request);
                break;
            case 'my_evaluations':
                # code...
                return $this->my_evaluations($request);
                break;
            case  'performanceDiscussion':
                return $this->getPerformanceDiscussion($request);
                break;
            case  'accept_evaluation':
                return $this->accept_evaluation($request);
                break;
                case  'get_hr_evaluation_assessments':
                return $this->get_hr_evaluation_assessments($request);
                break;
            case  'get_hr_promotion_evaluated_list':
                return $this->getHRUserPromotionEvaluatedList($request);
                break;
            case  'get_hr_promotion_not_evaluated_list':
                return $this->getHRUserPromotionNotEvaluatedList($request);
                break;
                
                case  'get_eligible_users_aper':
                return $this->getCadres($request);
                break;
                case  'get_eligible_users_cadre_ranks':
                return $this->getRanks($request);
                break;
                case  'get_eligible_ranks_users':
                return $this->getEligibleUsersAndAper($request);
                break;
                

            default:
                # code...
                break;

        }
    }

    public function processPost(Request $request){
        // try{
        switch ($request->type) {

            case 'save_performance_assessment':
                # code...
                return $this->save_performance_assessment($request);
                break;
            case 'saveDiscussion':
                return $this->saveDiscussion($request);
                break;

            default:
                # code...
                break;
        }

    }
    
    public function getHRUserList(Request $request)
    {

        $mp=AperMeasurementPeriod::find($request->mp);
         $evaluations=\App\AperAssessment::where('aper_measurement_period_id',$mp->id)->get();
        
        
        return view('aper.hr_users_list',compact('evaluations','mp'));

    }
     public function getHRUserPromotionEvaluatedList(Request $request){
         $mp=AperMeasurementPeriod::find($request->mp);
          $users=\App\User::whereHas('aper_assessments',function ($query) use($request)  {
            $query->where('aper_assessments.aper_measurement_period_id',$request->mp)
            ->where('aper_assessments.score','>',0);
        })->where(function ($query)  {
        $query->where(function ($query)  {
                $query->whereYear('users.date_of_present_appointment', '<=',date('Y',strtotime('-2 years')))
                	->whereHas('rank',function($query){
                	    $query->whereHas('grade',function($query){
                	    $query->whereBetween('grades.level', [1, 6]);
                	});
                	});
            })->orWhere(function ($query) {
                $query->whereYear('users.date_of_present_appointment', '<=',date('Y',strtotime('-3 years')))
                     	->whereHas('rank',function($query){
                	    $query->whereHas('grade',function($query){
                	    $query->whereBetween('grades.level', [7, 14]);
                	});
                     	});
            })->orWhere(function ($query) {
                $query->whereYear('users.date_of_present_appointment', '<=',date('Y',strtotime('-4 years')))
                     	->whereHas('rank',function($query){
                	    $query->whereHas('grade',function($query){
                	    $query->whereBetween('grades.level', [15, 17]);
                	});
                     	});
            });
           
    })
    ->where('users.status','<=',1)->get();
     return view('aper.hr_promotion_evaluated_list',compact('users','mp'));
   
     }
     public function getHRUserPromotionNotEvaluatedList(Request $request){
         $mp=AperMeasurementPeriod::find($request->mp);
          $users=\App\User::where(function($query) use($request){
        $query->whereHas('aper_assessments',function ($query) use($request)  {
            $query->where('aper_assessments.aper_measurement_period_id',$request->mp)
            ->where('aper_assessments.score','<=',0);
        })
        ->orWhereDoesntHave('aper_assessments',function($query){
            
        });
        })->where(function ($query)  {
        $query->where(function ($query)  {
                $query->whereYear('users.date_of_present_appointment', '<=',date('Y',strtotime('-2 years')))
                	->whereHas('rank',function($query){
                	    $query->whereHas('grade',function($query){
                	    $query->whereBetween('grades.level', [1, 6]);
                	});
                	});
            })->orWhere(function ($query) {
                $query->whereYear('users.date_of_present_appointment', '<=',date('Y',strtotime('-3 years')))
                     	->whereHas('rank',function($query){
                	    $query->whereHas('grade',function($query){
                	    $query->whereBetween('grades.level', [7, 14]);
                	});
                     	});
            })->orWhere(function ($query) {
                $query->whereYear('users.date_of_present_appointment', '<=',date('Y',strtotime('-4 years')))
                     	->whereHas('rank',function($query){
                	    $query->whereHas('grade',function($query){
                	    $query->whereBetween('grades.level', [15, 17]);
                	});
                     	});
            });
           
    })
    ->where('users.status','<=',1)->get();
    return view('aper.hr_promotion_not_evaluated_list',compact('users','mp'));
     }
     public function getCadres(Request $request){
         $cadres=\App\Cadre::orderBy('name')->get();
         return view('aper.aper_history',compact('cadres'));
     }
     public function getRanks(Request $request){
         $ranks=\App\Rank::where(['cadre_id'=>$request->cadre_id])->orderBy('position')->get();
         return view('aper.partials.aper_ranks',compact('ranks'));
     }
     public function getEligibleUsersAndAper(Request $request){
         $rank=\App\Rank::find($request->rank_id);
         $aper_info=[];
        //  return $rank->users;
        for($i=$rank->grade->promotion_year;$i>=1;$i--){
                 $year=date('Y')-$i;
                 
                    $aper_info['year'][]=$year;
                 
                 
                 $mp=AperMeasurementPeriod::whereYear('from',$year)->first();
         foreach($rank->users as $user){
             if($user->eligible==true){
                 $aper_info[$user->id]['id']=$user->id;
             $aper_info[$user->id]['name']=$user->name;
             $aper_info[$user->id]['emp_num']=$user->emp_num;
             $aper_info[$user->id]['zone']=$user->field_office?($user->field_office->zone?$user->field_office->zone->name:'No Zone'):' No Zone';
             $aper_info[$user->id]['field_office']=$user->field_office?$user->field_office->name:'';
             $department=\App\Department::find($user->department_id);
            //  dd($department);
             if($department){
                 $aper_info[$user->id]['department']=$department!=null?$department->name:'';
             }else{
                 $aper_info[$user->id]['department']='no department';
             }
                //  $aper_scores[$user->id][]=$date('Y')-$i;
                $as=\App\AperAssessment::where(['aper_measurement_period_id'=>$mp->id,'employee_id'=>$user->id])->first();
                if($as){
                    if(intval($as->score)!=0){
                        $aper_info[$user->id]['scores'][$year]=$as->score;
                    }else{
                        $aper_info[$user->id]['scores'][$year]='attempted_evaluation';
                    }
                
                
                }else{
                    $aper_info[$user->id]['scores'][$year]='not_evaluated';
                }
                 
             }
             }
         }
         return view('aper.partials.aper_users',compact('aper_info'));
        //   return $aper_info;
         
     }
     public function getZones(Request $request){
         $zones=\App\Zone::all();
         return view('aper.aper_history_by_zone',compact('zones'));
     }
     public function getFieldOffices(Request $request){
         $field_offices=\App\FieldOffice::where(['field_office_id'=>$request->field_office_id])->get();
         return view('aper.partials.aper_field_offices',compact('field_offices'));
     }
     public function getEligibleUsersAndAperZones(Request $request){
         $field_office=\App\FieldOffice::find($request->field_office_id);
         $aper_info=[];
        //  return $rank->users;
        for($i=4;$i>=1;$i--){
                 $year=date('Y')-$i;
                 
                    $aper_info['year'][]=$year;
                 
                 
                 $mp=AperMeasurementPeriod::whereYear('from',$year)->first();
         foreach($rank->users as $user){
             if($user->eligible==true){
             $aper_info[$user->id]['name']=$user->name;
             $aper_info[$user->id]['cadre']=$user->rank?($user->rank->cadre?$user->rank->cadre->name:'No cadre'):' No cadre';
             $aper_info[$user->id]['rank']=$user->rank?$user->rank->name:'';
             $aper_info[$user->id]['department']=$user->department?$user->department->name:'';
                //  $aper_scores[$user->id][]=$date('Y')-$i;
                $as=\App\AperAssessment::where(['aper_measurement_period_id'=>$mp->id,'employee_id'=>$user->id])->first();
                if($as){
                    if(intval($as->score)!=0){
                        $aper_info[$user->id]['scores'][$year]=$as->score;
                    }else{
                        $aper_info[$user->id]['scores'][$year]='attempted_evaluation';
                    }
                
                
                }else{
                    $aper_info[$user->id]['scores'][$year]='not_evaluated';
                }
                 
             }
             }
         }
         return view('aper.partials.aper_users',compact('aper_info'));
        //  return $aper_info;
         
     }
    public function getHRUserPromotionList(Request $request){
        
        return view('aper.promotable',compact('mp'));
    
    
    
    }

    public function getEvaluationUserList(Request $request)
    {

        $mp=AperMeasurementPeriod::find($request->mp);
        $manager=Auth::user();

        $users=User::whereHas('managers', function ($query) use($manager) {
            $query->where('manager_id',  $manager->id);
        })->where('hiredate','<=',$mp->to)->where('status','!=',2)->get();
        return view('aper.users_list',compact('users','mp'));

    }
    function getEvaluation(Request $request){
        $mp=AperMeasurementPeriod::find($request->mp);
        $manager=Auth::user();
        $employee=User::find($request->employee);
        $reports=User::whereHas('managers', function ($query) use($manager) {
            $query->where('manager_id',  $manager->id);
        })->where('hiredate','<=',$mp->to)->where('status','!=',2)->get();

        $evaluations=[];
        $evaluation=AperAssessment::where(['employee_id'=>$request->employee,'aper_measurement_period_id'=>$request->mp])->first();
         $aper_metrics=AperMetric::all();
        if (!$evaluation){
        $evaluation=AperAssessment::create(['employee_id'=>$request->employee,'manager_id'=>Auth::user()->id,'aper_measurement_period_id'=>$request->mp,
            'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id]);
        }
            foreach ($aper_metrics as $metric){
                $evaluations[$metric->id]['name']=$metric->name;
               foreach ($metric->sub_metrics as $sub_metric){
                   if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0){
                       $evaluations[$metric->id][$sub_metric->id]['name']=$sub_metric->name;
                       $assessment_detail=AperAssessmentDetail::where(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                           'user_id'=>$request->employee])->first();
                       if(!$assessment_detail){
                           $assessment_detail=AperAssessmentDetail::create(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                               'user_id'=>$request->employee,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id,'score'=>0
                           ]);
                       }
                       $evaluations[$metric->id][$sub_metric->id]['assessment_detail']=  $assessment_detail;
                   }
               }
            }

        return view('aper.evaluation',compact('evaluations','evaluation','reports','employee','mp','aper_metrics'));
    }

    public function save_performance_assessment(Request $request)
    {
        $evaluation=AperAssessment::find($request->assessmemt_id);
        $aper_metrics=AperMetric::all();
        $total_score=0;
        $obtainable_total_score=0;
        $obtainable_score=5;
        foreach ($aper_metrics as $metric){
            foreach ($metric->sub_metrics as $sub_metric){
                if (($sub_metric->editable==1 and $sub_metric->user_id==$evaluation->employee_id)||$sub_metric->editable==0){
                    $assessment_detail=AperAssessmentDetail::where(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                        'user_id'=>$evaluation->employee_id])->first();
                    $assessment_detail->score=$request['sub_metric_'.$sub_metric->id];
                    $assessment_detail->updated_by=Auth::user()->id;
                    $assessment_detail->save();
                    $total_score+=$assessment_detail->score ;
                    $obtainable_total_score+=$obtainable_score;
                }
            }

        }
        $score=($total_score/$obtainable_total_score)*20;
        $evaluation->total_score=$total_score;
        $evaluation->score=$score;
        $evaluation->employee_approved=0;
        $evaluation->manager_approved=1;
        $evaluation->manager_id=Auth::user()->id;
        $evaluation->manager_approved_date=date('Y-m-d');
        $evaluation->save();
        return redirect(url('aper/get_evaluation').'?employee='.$evaluation->employee_id.'&mp='.$evaluation->aper_measurement_period_id)->with('message','Evaluation Saved');

    }
    public function get_evaluation_assessments_preview(Request $request){

        $mp=AperMeasurementPeriod::find($request->mp);
        $manager=Auth::user();
        $employee=User::find($request->employee);
        $reports=User::whereHas('managers', function ($query) use($manager) {
            $query->where('manager_id',  $manager->id);
        })->where('hiredate','<=',$mp->to)->where('status','!=',2)->get();

        $evaluations=[];
        $evaluation=AperAssessment::where(['employee_id'=>$request->employee,'aper_measurement_period_id'=>$request->mp])->first();
        $aper_metrics=AperMetric::all();
        if (!$evaluation){
            $evaluation=AperAssessment::create(['employee_id'=>$request->employee,'manager_id'=>Auth::user()->id,'aper_measurement_period_id'=>$request->mp,
                'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id]);
        }
        foreach ($aper_metrics as $metric){
            $evaluations[$metric->id]['name']=$metric->name;
            foreach ($metric->sub_metrics as $sub_metric){
                if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0){
                    $evaluations[$metric->id][$sub_metric->id]['name']=$sub_metric->name;
                    $assessment_detail=AperAssessmentDetail::where(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                        'user_id'=>$request->employee])->first();
                    if(!$assessment_detail){
                        $assessment_detail=AperAssessmentDetail::create(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                            'user_id'=>$request->employee,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id,'score'=>0
                        ]);
                    }
                    $evaluations[$metric->id][$sub_metric->id]['assessment_detail']=  $assessment_detail;
                }
            }
        }
        return view('aper.partials.preview',compact('evaluations','evaluation','reports','employee','mp','aper_metrics'));
    }
    public function get_employee_evaluation_assessments(Request $request){

        $mp=AperMeasurementPeriod::find($request->mp);

        $employee=Auth::user();


        $evaluations=[];
        $evaluation=AperAssessment::where(['employee_id'=>$employee->id,'aper_measurement_period_id'=>$request->mp])->first();
        $aper_metrics=AperMetric::all();
        if (!$evaluation){
            return back()->with(['success'=>'You have not been evaluated for this period']);
        }
        foreach ($aper_metrics as $metric){
            $evaluations[$metric->id]['name']=$metric->name;
            foreach ($metric->sub_metrics as $sub_metric){
                if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0){
                    $evaluations[$metric->id][$sub_metric->id]['name']=$sub_metric->name;
                    $assessment_detail=AperAssessmentDetail::where(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                        'user_id'=>$employee->id])->first();
//                    if(!$assessment_detail){
//                        $assessment_detail=AperAssessmentDetail::create(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
//                            'user_id'=>$request->employee,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id,'score'=>0
//                        ]);
//                    }
                    $evaluations[$metric->id][$sub_metric->id]['assessment_detail']=  $assessment_detail;
                }
            }
        }

        return view('aper.employee_evaluation',compact('evaluations','evaluation','employee','mp','aper_metrics'));
    }
    public function export_assessment_pdf(Request $request){
        $mp=AperMeasurementPeriod::find($request->mp);
        $manager=Auth::user();
        $employee=User::find($request->employee);
        $reports=User::whereHas('managers', function ($query) use($manager) {
            $query->where('manager_id',  $manager->id);
        })->where('hiredate','<=',$mp->to)->where('status','!=',2)->get();

        $evaluations=[];
        $evaluation=AperAssessment::where(['employee_id'=>$request->employee,'aper_measurement_period_id'=>$request->mp])->first();
        $aper_metrics=AperMetric::all();
        if (!$evaluation){
            $evaluation=AperAssessment::create(['employee_id'=>$request->employee,'manager_id'=>Auth::user()->id,'aper_measurement_period_id'=>$request->mp,
                'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id]);
        }
        foreach ($aper_metrics as $metric){
            $evaluations[$metric->id]['name']=$metric->name;
            foreach ($metric->sub_metrics as $sub_metric){
                if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0){
                    $evaluations[$metric->id][$sub_metric->id]['name']=$sub_metric->name;
                    $assessment_detail=AperAssessmentDetail::where(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                        'user_id'=>$request->employee])->first();
                    if(!$assessment_detail){
                        $assessment_detail=AperAssessmentDetail::create(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                            'user_id'=>$request->employee,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id,'score'=>0
                        ]);
                    }
                    $evaluations[$metric->id][$sub_metric->id]['assessment_detail']=  $assessment_detail;
                }
            }
        }


        $view=$request->view;

            //return view();
            $pdf = \PDF::loadView('aper.partials.evaluation_preview_pdf',compact('evaluations','evaluation','reports','employee','mp','aper_metrics','view'));
            return @$pdf->download('performance evaluation.pdf');


    }

    public function export_assessment_excel(Request $request)
    {
        $mp=AperMeasurementPeriod::find($request->mp);
        $manager=Auth::user();
        $employee=User::find($request->employee);
        $reports=User::whereHas('managers', function ($query) use($manager) {
            $query->where('manager_id',  $manager->id);
        })->where('hiredate','<=',$mp->to)->where('status','!=',2)->get();

        $evaluations=[];
        $evaluation=AperAssessment::where(['employee_id'=>$request->employee,'aper_measurement_period_id'=>$request->mp])->first();
        $aper_metrics=AperMetric::all();
        if (!$evaluation){
            $evaluation=AperAssessment::create(['employee_id'=>$request->employee,'manager_id'=>Auth::user()->id,'aper_measurement_period_id'=>$request->mp,
                'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id]);
        }
        foreach ($aper_metrics as $metric){
            $evaluations[$metric->id]['name']=$metric->name;
            foreach ($metric->sub_metrics as $sub_metric){
                if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0){
                    $evaluations[$metric->id][$sub_metric->id]['name']=$sub_metric->name;
                    $assessment_detail=AperAssessmentDetail::where(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                        'user_id'=>$request->employee])->first();
                    if(!$assessment_detail){
                        $assessment_detail=AperAssessmentDetail::create(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                            'user_id'=>$request->employee,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id,'score'=>0
                        ]);
                    }
                    $evaluations[$metric->id][$sub_metric->id]['assessment_detail']=  $assessment_detail;
                }
            }
        }

        return     \Excel::create("Performance Evaluation", function($excel) use ($evaluations,$evaluation,$employee,$mp,$aper_metrics) {
            $excel->sheet('performance report', function($sheet) use ($evaluations,$evaluation,$employee,$mp,$aper_metrics) {

                $sheet->loadView('aper.partials.evaluation_preview_excel',compact('evaluations','evaluation','employee','mp','aper_metrics'))->setOrientation('landscape');
            });
        })->export('xlsx');

    }
    public function hr_evaluations(Request $request)
    {
        $measurement_periods=\App\AperMeasurementPeriod::all();
        return view('aper.hr_index',compact('measurement_periods'));
    }
    public function get_hr_evaluation_assessments(Request $request){

        $mp=AperMeasurementPeriod::find($request->mp);

        $employee=\App\User::find($request->employee);


        $evaluations=[];
        $evaluation=AperAssessment::where(['employee_id'=>$employee->id,'aper_measurement_period_id'=>$request->mp])->first();
        $aper_metrics=AperMetric::all();
        if (!$evaluation){
            return back()->with(['success'=>'You have not been evaluated for this period']);
        }
        foreach ($aper_metrics as $metric){
            $evaluations[$metric->id]['name']=$metric->name;
            foreach ($metric->sub_metrics as $sub_metric){
                if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0){
                    $evaluations[$metric->id][$sub_metric->id]['name']=$sub_metric->name;
                    $assessment_detail=AperAssessmentDetail::where(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
                        'user_id'=>$employee->id])->first();
//                    if(!$assessment_detail){
//                        $assessment_detail=AperAssessmentDetail::create(['aper_sub_metric_id'=>$sub_metric->id,'aper_assessment_id'=>$evaluation->id,
//                            'user_id'=>$request->employee,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id,'score'=>0
//                        ]);
//                    }
                    $evaluations[$metric->id][$sub_metric->id]['assessment_detail']=  $assessment_detail;
                }
            }
        }

        return view('aper.hr_evaluation',compact('evaluations','evaluation','employee','mp','aper_metrics'));
    }

    public function my_evaluations(Request $request)
    {
        $measurement_periods=\App\AperMeasurementPeriod::all();
        return view('aper.employee_index',compact('measurement_periods'));
    }
    public function getPerformanceDiscussion(Request $request){
        $discussions=AperPerformanceDiscussion::where('aper_assessment_id',$request->evaluation_id)->get();
        return view('aper.ajax.performanceDiscussion',compact('discussions'));
    }

    public function saveDiscussion(Request $request){
        // could become a potential problem better to use $request->id in the where clause, but this has its own importance
        $saveDiscussion=AperPerformanceDiscussion::updateOrCreate(['title'=>$request->title,'discussion'=>$request->discussion],$request->except('_token'));
//        $this->notifyHrAdminSaveDiscussion($saveDiscussion);
        return $this->getPerformanceDiscussion($request);
        // response()->json(['status'=>'success','message'=>'Peformance Discussion Succsessfully Saved']);

    }

    public function accept_evaluation(Request $request)
    {
         $evaluation =AperAssessment::find($request->evaluation_id);
        $evaluation->update(['employee_approved'=>$request->status,'employee_approved_date'=>date('Y-m-d')]);
        return 'success';
    }
    public function notifyHrAdminSaveDiscussion($evaluation){

        $Hrusers=\App\User::whereHas('role',function($query){
            $query->where('manages','all');
        } )->where('company_id',companyId())->get();
        foreach($Hrusers as $hr){
            $hr->notify((new NotifyHrSavePerformanceDiscussion("aper/get_hr_evaluation?employee={$evaluation->bscevaluation->user->id}&mp=$evaluation->evaluation_id",$evaluation->bscevaluation->user->name)));

        }
    }

    // incase it was requested
    public function deletePerformanceDiscussion(Request $request){
        AperPerformanceDiscussion::where('id',$request->id)->delete();
        return getPerformanceDiscussion($request);
    }



}
