<?php 
namespace App\Repositories\Traits;

trait VoteCategoryTrait {


public function Awards($id){
	$awardname = \App\Awards::where('id', $id )->first()->name;
	return $awardname;
}




public function AwardType($id){
	$awardtype = \App\AwardType::where('id', $id )->first();
	return isset($awardtype->name) ? $awardtype->name : $id;
}



function sumcategory($voted_for_id, $votecatid){
$sumcategory = \App\Voting::where('voted_for_id', $voted_for_id)->where('votecat_id', $votecatid )->where('year', session('FYI'))->sum('percentage');
	$sumcategory = round($sumcategory, 2);
	return $sumcategory;
}


	function calcAvg($score, $totalvote){
		if ($totalvote > 0){
			$avgscore = $score / $totalvote;
			$avgscore = number_format($avgscore, 1);
		}else{
			$avgscore = '';
		}
			return $avgscore;
	}

	function totalVoters($maxvote_voted_for_id, $vote_id){
		return \App\VoteReport::where('year', session('FYI'))->where('voted_for_id', $maxvote_voted_for_id)->where('votecat_id', $vote_id)->first();
	}

	function maxValue($vote_id,$filters){
		$maxValue= \App\VoteReport::where('year', session('FYI'))->where('votecat_id', $vote_id);
		if(isset($filters['cadre']) && $filters['cadre']!=''){
			$maxValue=$maxValue->whereHas('user.job',function($query) use($filters){
				$query->where('cadre_id',$filters['cadre']);
			});
		}

		if(isset($filters['zone']) && $filters['zone']!=''){
			$maxValue=$maxValue->whereHas('user.fieldoffice',function($query) use($filters){
				$query->where('zone_id',$filters['zone']);
			});
		}
		if(isset($filters['fieldoffice']) && $filters['fieldoffice']!=''){
			$maxValue=$maxValue->whereHas('user',function($query) use($filters){
				$query->where('field_office_id',$filters['fieldoffice']);
			});
		}
		return  number_format($maxValue->orderBy('total_percentage', 'DESC')->value('total_percentage'), 1);
	}

	function maxValueUser($vote_id,$filters){
		$maxUser=\App\VoteReport::where('year', session('FYI'))->where('votecat_id', $vote_id);

		if(isset($filters['cadre']) && $filters['cadre']!=''){
			$maxUser=$maxUser->whereHas('user.job',function($query) use($filters){
				$query->where('cadre_id',$filters['cadre']);
			});
		}


		if(isset($filters['zone']) && $filters['zone']!=''){
			$maxUser=$maxUser->whereHas('user.fieldoffice',function($query) use($filters){
				$query->where('zone_id',$filters['zone']);
			});
		}
		if(isset($filters['fieldoffice']) && $filters['fieldoffice']!=''){
			$maxUser=$maxUser->whereHas('user',function($query) use($filters){
				$query->where('field_office_id',$filters['fieldoffice']);
			});
		}

		return $maxUser->orderBy('total_percentage', 'DESC')->first();
	}


	function votePercentage(){
		$percentage= \App\CadreConfig::where('votecat_id', $this->id)->pluck('percentage')->first();
		return $percentage;

	}


	function getPercentage($cadre_id, $at, $ac, $votecat){
		$percentage= \App\CadreConfig::/*where('cadre_id', $cadre_id)->*/where('award_type', $at)->where('award_cat', $ac)->where('votecat_id', $votecat)->pluck('percentage')->first();
		return $percentage;

	}

}