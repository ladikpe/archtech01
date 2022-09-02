<?php

namespace App\Http\Controllers;

use App\ExamScore;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Excel;
use DB;


class ExamScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function examScores(Request $request){
        $year=Carbon::today()->format('Y');
        $scores = ExamScore::where('year',$year)/*->where('status','pending')*/->with('user')->get();
        return view('performance.exam_scores',compact('scores','year'));
    }

    public function examScoresTemplate(Request $request){
        $data=['Staff Id'];

        $users=User::all();
        $data=$users->map(function ($staff) {
            return ['Staff Id'=>$staff->emp_num,'Employee Name'=>$staff->name,'Score'=>'0','Year'=>Carbon::now()->format('Y')];
        });
        Excel::create('Exam Score Template', function($excel) use($data) {
            $excel->sheet('Staff List', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function examScoresImport(Request $request){
        if ($request->hasFile('template')) {
            //$year=\Helper::getfiscalforp();
            $year=Carbon::today()->format('Y');
            Excel::load($request->file('template')->getRealPath(), function ($reader) use ($year) {
                foreach ($reader->toArray() as $key => $row) {
                    $user=\App\User::where('emp_num',$row['staff_id'])->first();
                    if($user){
                        if (isset($row['score'])&& $row['score'] > 0 &&isset($row['year'])){
                            ExamScore::updateOrCreate(['user_id'=>$user->id,'score'=>$row['score'],'year'=>$row['year'],'status'=>'pending']);
                        }
                    }
                }
            });
            return 'success';
        }
    }
}
