<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable =['name','cadre_id','grade_id','position','exam_no_prefix'];
    protected $appends=['next_rank'];

    public function cadre()
    {
        return $this->belongsTo('App\Cadre','cadre_id');

    }
    public function grade()
    {
        return $this->belongsTo('App\Grade','grade_id');

    }
    public function users()
    {
        return $this->hasMany('App\User','rank_id');

    }
    public function current_rank_promotion()
    {
        return $this->hasMany('App\Promotion','old_rank');
    }
    public function current_rank_promotion_exam()
    {
        $year=Carbon::today()->format('Y');
        if (request()->filled('year')){
            $year=request()->year;
        }
        return $this->hasMany('App\Promotion','old_rank')->where('year',$year)->where('type','exam');
    }
    public function current_rank_promotion_advance()
    {
        $year=Carbon::today()->format('Y');
        if (request()->filled('year')){
            $year=request()->year;
        }
        return $this->hasMany('App\Promotion','old_rank')->where('year',$year)->where('type','advancement');
    }
    public function getNextRankAttribute(){
        $data=$this->only(array_merge($this->fillable,['id']));
        if(!$this->position){
            //if current rank has no position
            return $data;
        }
        $next_position=$this->position+1;
        $next_position_rank=Rank::where('position',$next_position)->where('cadre_id',$this->cadre_id)->first();
        if(!$next_position_rank){
            //if no higher rank
            return $data;
        }
        return $next_position_rank->only(array_merge($this->fillable,['id']));
    }
}
