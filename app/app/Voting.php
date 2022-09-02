<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    //
    protected $table = 'voting';
    protected $fillable = [];
    protected $hidden = ['updated_at', 'created_at'];


    public function Awards($id){
	$awardname = \App\Awards::where('id', $id )->first()->name;
	return $awardname;
}

	function userVotepercentage($voted_for_id, $voter_id, $award_cat, $attrib_id){
		$percentage = 	\App\Voting::where('year', session('FYI'))->where('voted_for_id', $voted_for_id)->where('voter_id', $voter_id)->where('award_cat', $award_cat)->where('votecat_id', $attrib_id)->first()->percentage;
		return $percentage;
	}


	function user(){
		return $this->belongsTo('\App\User', 'voter_id');
	}

	function user_voted_for(){
		return $this->belongsTo('\App\User', 'voted_for_id');
	}

	function votername(){
		return $this->belongsTo('\App\User', 'voter_id');
	}

	function votedname(){
		return $this->belongsTo('\App\User', 'voted_for_id');
	}


	function votecat($votecatid){
		return $this->belongsTo('\App\Vote', 'id');
	}




/////present copied updates FOR ALL-USER-VOTE

public function AWARDWinnerGroup($groupid, $award_cat,$request){
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



public function voteNum($awardcat, $voted_for_id,$request){

	$voteNum=\App\VoteReport::where('year', session('FYI'))
							->where('award_cat', $awardcat)
							->where('voted_for_id', $voted_for_id)->first();
							/*->distinct('voter_id')*/
							/*->groupBy('voter_id')*/
							/*->count('voter_id');*/
							// dd($voteNum);
        
	return (isset($voteNum->total_votes)) ? $voteNum->total_votes : '_' ;
}







}
