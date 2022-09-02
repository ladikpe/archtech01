<?php

namespace App\Http\Controllers;

use App\AperAssessment;
use App\AperMeasurementPeriod;
use App\Cadre;
use App\Grade;
use App\Promotion;
use App\PromotionLog;
use App\User;
use App\Rank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Excel;
use DB;

class PromotionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function populateEligibleStaff(){
        $this_year=Carbon::today()->format('Y');
        $date=Carbon::today();
        //delete all promotion for the year
        Promotion::where('year',$this_year)->delete();
        //exam promotion eligible
        $this_year_eligible=User::EligibleStaff();
        $aper_measurement_period=AperMeasurementPeriod::whereYear('from','<',$this_year)->whereYear('from','>=',$this_year-3)->pluck('id')->toArray();
        foreach ($this_year_eligible as $staff){
            $tries=0;
            $failed_last_year=Promotion::where('year',$this_year-1)->where('user_id',$staff->id)->whereIn('status',['fail'])->first();
            if ($failed_last_year){
                $tries=$failed_last_year->tries+1;
            }
            $seniority_score= $tries*2;
            $score=AperAssessment::where('employee_id',$staff->id)->whereIn('aper_measurement_period_id',$aper_measurement_period)->sum('score');
            $aper_score=$score/3;
            $level=$staff->rank->grade ? $staff->rank->grade->level: '1';
            $exam_number="Ferma/Engr/{$staff->rank->exam_no_prefix}/{$level}/{$date->format('y')}/$staff->id";
            $array=  [
                'state'=>$staff->state ? $staff->state->name : '',
                'dob'=>$staff->dob,
                'first_appointment'=>$staff->hiredate->format('Y-m-d'),
                'date_of_confirmation'=>$staff->confirmation_date,
                'present_appointment'=>$staff->last_promoted,
                'old_rank'=>$staff->rank_id,
                'new_rank'=>$staff->getNextRank($staff->rank_id!=0 ?$staff->rank_id : 1)['id'],
                'exam_number'=>$exam_number,
                'aper_score'=>$aper_score,
                'tries'=>$tries,
                'seniority_score'=>$seniority_score,
                'status'=>'pending',
                'type'=>'exam'
            ];
            $promotion=Promotion::updateOrCreate(['user_id'=>$staff->id, 'emp_num'=>$staff->emp_num,'year'=>$this_year],$array);
            $this->calculatePromotionScore($promotion);
        }

        //get correct exam number
        $ranks=Rank::whereHas('current_rank_promotion',function ($query)use($this_year){
            $query->where('year',$this_year);
        })->get();
        foreach ($ranks as $rank){
            $promotions = Promotion::where('year',$this_year)->where('old_rank',$rank->id)->with('user')->get();
            $promotions=$promotions->sortBy('present_appointment')->sortBy('first_appointment')->sortBy('dob');
            foreach ($promotions as $key=>$promotion){
                $level=$promotion->user->rank->grade ? $promotion->user->rank->grade->level: '1';
                $key2=$key+1;
                $exam_number="Ferma/Engr/{$promotion->user->rank->exam_no_prefix}/{$level}/{$this_year}/{$key2}";
                $promotion->update(['exam_number'=>$exam_number]);
            }
        }


        //advancement promotion eligible
        $advancement_cadres=Cadre::where('promotion_type','advancement')->pluck('id')->toArray();
        $grades_8=Grade::where('level','8')->pluck('id')->toArray();
        $grades_ranks=Rank::whereIn('grade_id',$grades_8)->whereIn('cadre_id',$advancement_cadres)->pluck('id')->toArray();

        $this_year_advancement_eligible=User::whereIn('rank_id',$grades_ranks)->whereYear('last_promoted','<=',$this_year-2)->get();
        foreach ($this_year_advancement_eligible as $staff){
            $array=  [
                'state'=>$staff->state ? $staff->state->name : '',
                'dob'=>$staff->dob,
                'first_appointment'=>$staff->hiredate->format('Y-m-d'),
                'date_of_confirmation'=>$staff->confirmation_date,
                'present_appointment'=>$staff->last_promoted,
                'old_rank'=>$staff->rank_id,
                'new_rank'=>$staff->getNextRank($staff->rank_id!=0 ?$staff->rank_id : 1)['id'],
                'exam_number'=>'null',
                'aper_score'=>'0',
                'tries'=>0,
                'seniority_score'=>0,
                'status'=>'pass',
                'type'=>'advancement'
            ];
            Promotion::updateOrCreate(['user_id'=>$staff->id, 'emp_num'=>$staff->emp_num,'year'=>$this_year],$array);
        }
    }

    private function calculatePromotionScore($promotion){
        if (isset($promotion->exam_score) &&isset($promotion->aper_score) &&isset($promotion->seniority_score)) {
            $sum=$promotion->exam_score+$promotion->aper_score+$promotion->seniority_score;
            $status= $sum>=60 ? 'pass' : 'fail';
            $promotion->update(['status'=>$status]);
        }
    }
    public function module(Request $request){
        $year=Carbon::today()->format('Y');
        if ($request->filled('year')){
            $year=$request->year;
        }
        return view('performance.promotion.module',compact('year'));
    }
    public function promotionsByExam(Request $request){
        $year=Carbon::today()->format('Y');
        if ($request->filled('year')){
            $year=$request->year;
        }
        $ranks=Rank::withCount('current_rank_promotion_exam')->whereHas('current_rank_promotion',function ($query)use($year){
            $query->where('year',$year)->where('type','exam');
        })->get();
        $type='exam';
        return view('performance.promotion.promotions',compact('year','ranks','type'));
    }

    public function promotionsByAdvancement(Request $request){
        $year=Carbon::today()->format('Y');
        if ($request->filled('year')){
            $year=$request->year;
        }
        $ranks=Rank::withCount('current_rank_promotion_advance')->whereHas('current_rank_promotion',function ($query)use($year){
            $query->where('year',$year)->where('type','advancement');
        })->get();
        $type='advancement';
        return view('performance.promotion.promotions',compact('year','ranks','type'));
    }

    public function loadRankPromotions(Request $request){
        $year=$year=Carbon::today()->format('Y');
        $rank=1;
        $type='exam';
        if ($request->filled('year')){
            $year=$request->year;
        }
        if ($request->filled('rank')){
            $rank=$request->rank;
        }
        if ($request->filled('type')){
            $type=$request->type;
        }
        $promotions = Promotion::where('year',$year)->where('type',$type)
            ->where('old_rank',$rank)->with('user')->with('oldrank.cadre')->with('oldrank.grade')->with('newrank.cadre')->get();
        $rank=Rank::find($rank);
        return view('performance.promotion.promotion_list',compact('promotions','year','rank','type'));
    }

    public function downloadTemplate(){
        $year=Carbon::today()->format('Y');
        $view = 'performance.promotion.promotion_excel_template';
        $name=$year.' Promotion Exam template';
        $promotions = Promotion::where('year',$year)->where('type','exam')->with('user')->get();
        return \Excel::create($name, function ($excel) use ($view, $name,$promotions) {
            $excel->sheet($name, function ($sheet) use ($view,$promotions) {
                $sheet->loadView("$view", compact('promotions'))->setOrientation('landscape');
            });
        })->export('xlsx');
    }
    public function importTemplate(Request $request ){
        if ($request->hasFile('template')) {
            //$year=\Helper::getfiscalforp();
            $year=Carbon::today()->format('Y');
            Excel::load($request->file('template')->getRealPath(), function ($reader) use ($year) {
                foreach ($reader->toArray() as $key => $row) {
                    $user=\App\User::where('emp_num',$row['staff_id'])->first();
                    $exam_number= isset($row['exam_number']) ? $row['exam_number'] : '';
                   
                    $profession_exam_score= isset($row['profession_exam_score']) ? $row['profession_exam_score'] : 0;
                    $civil_service_exam_score= isset($row['civil_service_exam_score']) ? $row['civil_service_exam_score'] : 0;
                     $general_paper_exam_score= isset($row['general_paper_exam_score']) ? $row['general_paper_exam_score'] : 0;
                      $exam_score= $profession_exam_score + $civil_service_exam_score +  $general_paper_exam_score;
                    if($user && $exam_score>0 && $exam_score<=70){
                        $promotion=Promotion::where(['user_id'=>$user->id,'emp_num'=>$user->emp_num,'year'=>$year])
                            ->update(['exam_score_uploaded_by'=>Auth::id(),'exam_score'=>$exam_score,'profession_exam_score'=>$profession_exam_score,
                            'civil_service_exam_score'=>$civil_service_exam_score,'general_paper_exam_score'=>$general_paper_exam_score]);
                        $this->calculatePromotionScore($promotion);
                    }
                }
            });
            return 'success';
        }
    }
    public function promote(Request $request){
        $pendings=$request->promotions;
        $promotions=Promotion::where('status','pass')->whereIn('id',$pendings)->get();
        foreach ($promotions as $promotion){
            $this_year=Carbon::today()->format('Y');
            $this->promoteUser($promotion->user_id,$this_year);
        }
        return 'success';

    }
    private function promoteUser($user_id,$this_year){
        $user=User::find($user_id);

        $old_rank=$user->rank_id;
        $new_rank_id=$user->aspiring_rank()['id'];

        PromotionLog::updateOrcreate(['user_id'=>$user_id,'year'=>$this_year],
            ['old_rank_id'=>$old_rank,'new_rank_id'=>$new_rank_id,'approved_by'=>Auth::id(),'promotion_date'=>Carbon::today()]);
        $new_rank=Rank::find($new_rank_id);
        User::where('id',$user_id)->update(['rank_id'=>$new_rank_id,'grade_id'=>$new_rank->grade_id]);
    }

    private function rollBackPromotion(){

    }

    public function bulkUpdateTemplate(){
        $data=User::select('id as id','emp_num as StaffID','name as Name')->whereIn('status',[1,0])->get();
        //$data=DB::table('users')->select('id as id','emp_num as StaffID','name as Name','status')->whereIn('status',[1,0])->get();
        Excel::create('Staff Update Template', function($excel) use($data) {
            $excel->sheet('Staff List', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function bulkUpdateImport(Request $request){
        if ($request->hasFile('file')) {
            Excel::load($request->file('file')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    $user=\App\User::where('emp_num',$row['staffid'])->where('id',$row['id'])->first();
                    if($user){

                    }
                }
            });

            return 'success';

        }
    }

    public function exportPromotionDetails(Request $request){
        $type='exam';
        $year=Carbon::today()->format('Y');
        if ($request->filled('type')){
            $type=$request->type;
        }
        if ($request->filled('year')){
            $year=$request->year;
        }
        $ranks=Rank::whereHas('current_rank_promotion',function ($query)use($year){
            $query->where('year',$year)->where('type','exam');
        })->with(['current_rank_promotion' => function ($query) use ($year){
            $query->where('year',$year)->where('type','exam');
        }])->get();


        $view = 'performance.promotion.promotion_excel_export';
        $name=$year.' Promotion Exam Export';

        $promotions = Promotion::where('year',$year)->where('type','exam')->with('user')->get();
        return \Excel::create($name, function ($excel) use ($view, $name,$promotions,$ranks) {
            $excel->sheet($name, function ($sheet) use ($view,$promotions,$ranks) {
                $sheet->loadView("$view", compact('promotions','ranks'))->setOrientation('landscape');
            });
        })->export('xlsx');

    }
}
