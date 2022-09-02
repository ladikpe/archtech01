<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable=['user_id','emp_num','state','dob','first_appointment','date_of_confirmation','present_appointment',
    'old_rank','new_rank','year','exam_number','tries','status','exam_score','aper_score','seniority_score','exam_score_uploaded_by','type','profession_exam_score','civil_service_exam_score','general_paper_exam_score'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function oldrank(){
       return $this->belongsTo('App\Rank','old_rank')->withDefault();
    }

    public function newrank(){
       return $this->belongsTo('App\Rank','new_rank')->withDefault();
    }
}
