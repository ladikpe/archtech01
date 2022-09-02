<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Vote;
use App\VoteEligibility;

class Awards extends Model
{
    protected $table = 'voteawards';
    protected $fillables = [];


function AWARDEligibilityCount($awardcat){
  $eligibilitycount = VoteEligibility::where('ac', $awardcat)->where('year', session('FYI'))->count();
  switch($eligibilitycount){
    case 0: 
      return 'Not Applicable';
    break;
    case 1:
      return '1 Eligible Voter';
    break;
    case $eligibilitycount > 1:
      return $eligibilitycount.' Eligible Voters';
    break;
    default:
  }
}




function AWARDType($awardid){
  $awardtype = AWARDType::where('id', $awardid)->take(1)->first();
  return $awardtype;
}

/////VOTEREPORT BLADE
public function AWARDWinnerGroup($groupid, $award_cat,$request){
        $groupid=$this->GroupAwardTrial($award_cat)->voted_for_id;
  $catlist = Vote::where('award_cat', $award_cat)->where('award_type', 2)->get();
          $needle = explode(" ",strtolower(VoteAwards::where('id', $award_cat)->first()->name));
          switch(true){
            case in_array('unit', $needle) || in_array('units', $needle):
            $user = \App\JobDepNew::where('id', $groupid)->first();
            break; 
            case in_array('department', $needle) || in_array('departments', $needle): 
            $user = \App\JobDepNew::where('id','<>',0)->where('type', 'dept')->where('id', $groupid)->first();
            break; 
            case in_array('zone', $needle) || in_array('zones', $needle):
            $user = \App\Zone::where('id', $groupid)->first();
            break; 
            case in_array('state', $needle):
            $user = \App\FieldOffice::where('id', $groupid)->first();
            break;  
            default:
            break;
          }
      return $user;


}

public function GroupAwardTrial($awardcat){

    $maxUser=\App\VoteReport::where('year', session('FYI'))->where('award_cat', $awardcat)
                            ->groupBy('voted_for_id')
                            ->selectRaw('SUM(total_percentage) as sumPercentage, voted_for_id, award_type,award_cat')
                            ->orderBy('sumPercentage','desc')
                           
                            ->first();
 
              return $maxUser;
}



private function getAwardType($cat_id){
  return \App\Awards::where('id',$cat_id)->value('award_type');
}


public function AWARDWinner($awardcat,$request){
  $data=collect($request);
  if($this->getAwardType($awardcat)==2) { return $this->GroupAwardTrial($awardcat); }
	$maxUser=\App\VoteReport::where('year', session('FYI'))->where('award_cat', $awardcat)
                ->wherehas('user',function($query) use($request,$data){
                              if(isset($request['department']) && $request['department'] !=''){
                                $query->where('workdept_id', $request['department']);
                              }
                              if(isset($request['unit']) && $request['unit'] !=''){
                                $query->where('unit_id', $request['unit']);
                              }
                              if(isset($request['fieldoffice']) && $request['fieldoffice'] !=''){
                                 $query->where('field_office_id', $request['fieldoffice']);
                              }
                             })
							->groupBy('voted_for_id')
							->selectRaw('SUM(total_percentage) as sumPercentage, voted_for_id, award_type,award_cat')
							->orderBy('sumPercentage','desc')
							->with('user','voteawards')
							->first();
	return  ($maxUser);
}

 

public function voteNum($awardcat, $voted_for_id,$request){

	$voteNum=\App\VoteReport::where('year', session('FYI'))
							->where('award_cat', $awardcat)
              ->where('voted_for_id', $voted_for_id)->first();
							/*->distinct('voter_id')*/
							/*->groupBy('voter_id')*/
							/*->count('voter_id');*/
							// dd($voteNum);
        
	return (isset($voteNum->total_votes)) ? $voteNum->total_votes : 1 ;
}

function user(){
	return $this->belongsTo('\App\User', 'voted_for_id');
}

}
