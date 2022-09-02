<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cadre;
use App\CadreConfig;
use App\Vote;
use App\Voting;
use App\VoteReport;
use App\Awards;
use App\AwardType;
use App\VoteAwards;
use App\VoteEligibility;
use App\VoteYear;
use Carbon\Carbon;

class VoteController extends Controller
{

  public function __construct(){
    $this->middleware('auth');

    if(!session()->has('FYI')){
      $activeYear = VoteYear::where('status','1')->orderBy('id','desc')->value('year');
      session(['FYI'=>$activeYear]);
    }

  }

  public function allvotesettings(Request $request){

      $this->permissionCheck();
    return view('settings.votesettings.index');
  }

  public function switch(Request $request, $id){
    fwrite(fopen(storage_path("rudder.db"), 'w'), $id);
    $awardyears = VoteYear::get();
    $voteswitch = $this->readRudder();
    return view('settings.votesettings.awardyear', compact('awardyears','voteswitch'));
  }

  public function permissionCheck($permission_type='configure_vote'){
//      request()->request->add(['permission_type'=>$permission_type]);
//      $this->middleware('vote_middleware');
 }

 public function eligiblityCheck($ac){
  if(!\eligible(\Auth::user()->id, $ac, session('FYI') )){
    return redirect('startmenu')->with('error', 'You are not Eligible to vote this AWARD Category.');
  }
}

 public function StatusCheck(){
  if($this->readRudder() != '1'){
    return redirect("/")->with('error','Voting is currently disabled by the Administrator.');
  }
}

public function readRudder(){
  return fread(fopen(storage_path("rudder.db"), 'r'), filesize(storage_path("rudder.db")));
}



////////LIST/CREATE/UPDATE AWARD YEAR//////
public function awardsyear(Request $request){
  $this->permissionCheck();
  $awardyears = VoteYear::get();
  $voteswitch = $this->readRudder();
  return view('settings.votesettings.awardyear', compact('awardyears','voteswitch'));
}

public function CreateYear(Request $request){
  $this->permissionCheck();
  $year = trim($request->input('year'));
  VoteYear::insert(['year' => $year]);
    return redirect('settings')->with('success','AWARD Year has been Selected');
 }

 public function SelectYear(Request $request){
  $this->permissionCheck();
  $year = trim($request->input('award_year'));
  VoteYear::where('status', '<>', 0)->update(array('status' => 0));
  VoteYear::where('year', $year)->update(array('status' => 1));
  session()->forget('FYI');
  return response()->json(['status'=>'success','message'=>'AWARD Year has been Updated']);
 }


////////LIST/CREATE/UPDATE AN AWARD//////
public function awards(Request $request){
  $this->permissionCheck();
  $awards = Awards::where('award_type', 1)->get();
  $awards2 = Awards::where('award_type', 2)->get();
  $awards3 = Awards::where('award_type', 3)->get();
  $awardtype = AwardType::get();
  $voteswitch = $this->readRudder();
  return view('settings.votesettings.awards', compact('awards', 'awards2', 'awards3', 'awardtype', 'voteswitch'));
}

public function CreateOrUpdate(Request $request){
  $this->permissionCheck();
  $categoryid = $request->input('id');
  $name = ucwords(trim(strtolower($request->input('name'))));
  $awardtype = $request->input('awardtype');
  if(empty($categoryid)){
    !empty($name) ? VoteAwards::insert(['name' => $name, 'award_type' => $awardtype]) : '';
    return redirect('settings')->with('success','A New AWARD Category has been Created');
  }else{
    $obj = VoteAwards::find($categoryid);
    $obj->name  = $name;
    $obj->save();
    return redirect('settings')->with('success','AWARD Category has been Updated');
  }
}


//////LIST/CREATE/UPDATE AWARD ATTRIBUTE/////
public function awardsattributes(Request $request){
  $this->permissionCheck();
  $filters = $request->all();
  $awardcategory = Awards::where('award_type', '<>', 3)->get();
  $awardtype = AwardType::where('id', '<>', '3')->get();
  $attributeslist = Vote::select('name', 'descr')->groupBy('name')->get();
  if(isset($filters['awardcategory']) && $filters['awardcategory']!='' && isset($filters['awardtype']) && $filters['awardtype']!=''){
    $attributes = Vote::where('award_cat', $filters['awardcategory'])->where('award_type', $filters['awardtype'])->get();
  }else{
    $attributes = Vote::take(15)->get();
  }
  return view('settings.votesettings.attributes', compact('attributes', 'awardcategory', 'awardtype', 'attributeslist'));
}

public function CreateOrUpdateAttr(Request $request){
  $this->permissionCheck();
  $id = $request->input('id');
  $awardcategory = $request->input('awardcategory');
  $awardtype = $request->input('awardtype');
  $name = $request->input('name');
  if(!empty($id)){
    $obj = Vote::find($id);
    $obj->name  = $name;
    $obj->descr  = $request->input('descr');
    $obj->save();
    return redirect('settings')->with('success','AWARD Attribute has been updated.');
  }else{
    if(!empty($name) && $awardcategory !='' &&  $awardtype != ''){
     $insert = Vote::insert(['name' => $name, 'descr' => $request->input('cdescr'), 'award_cat' => $awardcategory, 'award_type' => $awardtype]);
     return redirect('settings')->with('success','Attribute have been created successfully.');
     }else{
      return redirect('settings')->with('error','Something went wrong.');
    }
  }

}



//////LIST/CREATE/UPDATE AWARD ATTRIBUTE CONFIG/////
public function awardattributes_config(Request $request){
  $this->permissionCheck();
  $awardcategory = Awards::where('award_type', '<>', 3)->get();
  $awardtype = AwardType::where('id', '<>', '3')->get();
  $cadgrp = [];
  if($request->has('awardtype') && $request->awardtype!='' && $request->has('awardcategory') && $request->awardcategory!=''){
    $votelists = Vote::where('id','>',0);
    $votelists=$votelists->where('award_type', $request->awardtype)->where('award_cat', $request->awardcategory);
  }else{
    $votelists = Vote::take(0);
  }
  $votelists=$votelists->get();
  return view('settings.votesettings.configurations', compact('votelists', 'cadgrp', 'awardcategory', 'awardtype'));
}

public function awardattributes_config_update(Request $request){

  $this->permissionCheck();
  $args = $request->all();
  $awardcat = $args['award_cat'];
  $awardtype = $args['award_type'];
  $value=explode(',',$request->config);
  $vot_cat_ids=explode(',',$request->vot_cat_id);

  $i=0;
  foreach ($vot_cat_ids as $vot_cat_id) {

    $exists=CadreConfig::where('award_cat', $awardcat)->where('award_type', $awardtype)->where('votecat_id',$vot_cat_id)->first();
    if ($exists) {
     $obj = CadreConfig::find($exists->id);
   }
   else{
     $obj = new CadreConfig;
     $obj->award_cat = $awardcat;
     $obj->award_type = $awardtype;
     $obj->votecat_id = $vot_cat_id;
   }
   $obj->percentage = $value[$i];
   $obj->save();
   $i++;
 }
 return response()->json(['status'=>'success', 'message'=>'Configurations was set successful.'],200);

}



#####VOTING CATEGORIES SETUPS :: MODULE 1#####
 //////DISPLAY ALL LIST OF VOTING CATEGORIES/////
public function showvotecategories(){
  $lists = Vote::get();
  return view('voting.configure_cat', compact('lists'));
}

 //////DELETE A VOTING AWARD///////
public function deleteVoteAward(Request $request){
  $categoryid = $request->input('id');
  $rowCount = (int)Voting::where('award_cat', $categoryid)->count();
  switch(true){
    case ($rowCount > 0):
      return $rowCount;
    break;
    case $rowCount == 0:
    $deletecat = VoteAwards::where('id', $categoryid)->delete();
      if($deletecat){
        return 'success';
      }else{
       return 'error';
      }
     break;
     default:
       return 'eof';
     break;
 }

}


 //////DELETE A VOTING ATTRIBUTE//
public function deletevoteattr(Request $request){
  $id = $request->input('id');
  $rowCount = (int)Voting::where('votecat_id', $id)->count();
  switch(true){
    case ($rowCount > 0):
    return $rowCount;
    break;
    case $rowCount == 0:
    $deletecat = Vote::where('id', $id)->delete();
      if($deletecat){
        return 'success';
      }else{
       return 'error';
      }
     break;
     default:
      return 'eof';
     break;
 }

}




public function votestartmenu(Request $request){
  $this->StatusCheck();
  $awardtype = AwardType::where('id', '<>', '3')->get(); //Get Individual and Team award
  $aitc = (int)count(Vote::where('award_type', 1)->groupBy('award_cat')->get());  //Individual Awards Count
  $attc = (int)count(Vote::where('award_type', 2)->groupBy('award_cat')->get());  //Team Awards Count
  $voteswitch = $this->readRudder();

  $awardcategory = [];
  $at = trim($request->input('at')); ///Award type
  $ac = trim($request->input('ac')); ///Award Category
  $response = NULL;
  $users = NULL;

  if(!empty($request->input('id'))){
    $awardcategory = Vote::where('award_type', $request->input('id'))->groupBy('award_cat')->get();
    if(count($awardcategory) < 1){
      $response = "No \"".base64_decode($request->input('type'))."\" AWARD found, try again later";
    }
  }

  switch(true){
    case $at == '1':
    if(!empty($at) || !empty($ac)){
      $workstate_id =  \Auth::user()->workstate_id;
      $unit_id = isset($request->user()->unit->id) ? $request->user()->unit->id : 0;
      $detectCategory = $this->detectCategory($request);
      $users=$usercount=User::where('id','<>',$request->user()->id)->where(function($query) use ($detectCategory,$unit_id){
        if($detectCategory =='driver'){
           $query->where('duty', 'driver');
         }elseif ($detectCategory=='frme') {
          $query->orwhere('duty', 'frme');
        }elseif ($detectCategory=='zonal') {
          $query->orwhere('duty', 'zonal');
        }else{
          $query->where('unit_id', $unit_id);
        }
    });

      $users = $users->inRandomOrder()->get();

      $progressCount['totalCount'] = $usercount->where('id','<>',$request->user()->id)->count();
      $progressCount['remainder'] = $usercount->whereDoesntHave('myvote',function($query) use($request,$at,$ac){
       $query->where(['award_cat'=>$ac,'award_type'=>$at,'year'=> session('FYI')])
       ->where('voter_id',$request->user()->id);
     })->count();
      $progressCount['votedForCount'] = (  $progressCount['totalCount'] -   $progressCount['remainder']);

    }
    break;

    case $at == '2' :
    $needle = explode(" ",strtolower(VoteAwards::where('id', $ac)->first()->name));
    switch(true){
      case in_array('unit', $needle) || in_array('units', $needle):
      $users = \App\JobDepNew::where('id','<>',0)->where('unitLive', '1');
      break;
      case in_array('department', $needle) || in_array('departments', $needle):
      $users = \App\JobDepNew::where('id','<>',0)->where('type', 'dept');
      $usercount = \App\JobDepNew::where('id','<>',0)->where('type', 'dept');
      break;
      case in_array('zone', $needle) || in_array('zones', $needle):
      $users = \App\Zone::inRandomOrder()->get();
      break;
      case in_array('state', $needle):
      $users = \App\FieldOffice::where('id','<>',0);
      break;
    }

    $progressCount['totalCount'] = $users->count();
    $progressCount['remainder'] = $users->whereNotIn('id',$this->getVotedID($at,$ac))->count();
    $progressCount['votedForCount'] = ($progressCount['totalCount'] - $progressCount['remainder']);
    $users = $users->inRandomOrder()->get();
  }
  return view('voting.startmenu', compact('awardtype', 'awardcategory', 'response', 'users', 'voteswitch', 'aitc', 'attc', 'progressCount'));
}




private function detectCategory(Request $request){
  $checkType = NULL;
  $cat_name = explode(' ',strtolower(base64_decode($request->input('dd'))));
  switch ($cat_name) {
    case in_array('driver', $cat_name):
    $checkType = 'driver';
    break;
    case in_array('frme', $cat_name):
    $checkType = 'frme';
    break;
    case in_array('zonal', $cat_name):
    $checkType = 'zonal';
    break;
  }
  return $checkType;
}


public function getMyVotee($user,$request, $userid){
 if(!$request->has('page')){
  $user=$user->where('id', $userid);
  }
  return $userss=$user->simplePaginate(1);
}


#####VOTE EMPLOYESS :: MODULE 2#####
//////////////INDIVIDUAL VOTE///////////////
public function voteByUser(Request $request, $userid){
  $at = (int)$request->input('at');
  $ac = (int)$request->input('ac');
  $catlist = \App\Vote::where('award_cat', $ac)->where('award_type', $at)->get();
  $this->eligiblityCheck($ac);
  $voteswitch = $this->readRudder();

  $workstate_id = \Auth::user()->workstate_id;
  $unit_id = isset($request->user()->unit->id) ? $request->user()->unit->id : 0;
  $detectCategory= $this->detectCategory($request);
  $users=$userCount=User::where('id', '<>', $request->user()->id)->where(function($query) use ($detectCategory,$unit_id){

    if($detectCategory =='driver'){
      $query->orwhere('duty', 'driver');
     }elseif ($detectCategory=='frme') {
      $query->orwhere('duty', 'frme');
    }elseif ($detectCategory=='zonal') {
      $query->orwhere('duty', 'zonal');
    }else{
      $query->where('unit_id', $unit_id);
    }
});

  $progressCount['totalCount'] = $userCount->count();
  $progressCount['remainder'] = $userCount->whereDoesntHave('myvote',function($query) use($request,$at,$ac){
    $query->where(['award_cat'=>$ac,'award_type'=>$at,'year'=> session('FYI')])
    ->where('voter_id',$request->user()->id);
  })->count();

  $userss =$this->getMyVotee($users, $request, $userid);
  $progressCount['votedForCount'] =  $progressCount['totalCount'] -   $progressCount['remainder'];
  return view('voting.vote', compact('userss', 'voteswitch', 'catlist', 'progressCount'));
}


//////////////TEAM VOTE///////////////
public function voteByGroup(Request $request, $groupid){
  $at = (int)$request->input('at');
  $ac = (int)$request->input('ac');
  $catlist = Vote::where('award_cat', $ac)->where('award_type', $at)->get();
  $needle = explode(" ",strtolower(VoteAwards::where('id', $ac)->first()->name));
  $this->eligiblityCheck($ac);
  $voteswitch = $this->readRudder();

  switch(true){
    case in_array('unit', $needle) || in_array('units', $needle):
    $user = \App\JobDepNew::where('id','<>',0)->where('id', $groupid)->orWhere('id','<>',0)->where('unitLive', '1');
    $progressCount['totalCount'] = \App\JobDepNew::where('id','<>',0)->where('unitLive', '1')->count();
    $progressCount['remainder'] = \App\JobDepNew::where('id','<>',0)->where('unitLive', '1')->whereNotIn('id',$this->getVotedID($at,$ac))->count();
    $progressCount['votedForCount'] = ($progressCount['totalCount'] - $progressCount['remainder']);
    break;
    case in_array('department', $needle) || in_array('departments', $needle):
    $user = \App\JobDepNew::where('id','<>',0)->where('type', 'dept')->where('id', $groupid)->orWhere('id','<>',0)->where('type', 'dept');
    $progressCount['totalCount'] = \App\job_dep::where('id','<>',0)->where('type', 'dept')->count();
    $progressCount['remainder'] = \App\job_dep::where('id','<>',0)->where('type', 'dept')->whereNotIn('id',$this->getVotedID($at,$ac))->count();
    $progressCount['votedForCount'] = ($progressCount['totalCount'] - $progressCount['remainder']);
    break;
    case in_array('zone', $needle) || in_array('zones', $needle):
    $user = \App\Zone::where('id','<>',0)->where('id', $groupid)->orWhere('id','<>',0);
    $progressCount['totalCount'] = \App\Zone::count();
    $progressCount['remainder'] = \App\Zone::whereNotIn('id',$this->getVotedID($at,$ac))->count();
    $progressCount['votedForCount'] = ($progressCount['totalCount'] - $progressCount['remainder']);
    break;
    case in_array('state', $needle):
    $user = \App\FieldOffice::where('id','<>',0)->where('id', $groupid)->orWhere('id','<>',0);
    $progressCount['totalCount'] = \App\FieldOffice::count();
    $progressCount['remainder'] = \App\FieldOffice::whereNotIn('id',$this->getVotedID($at,$ac))->count();
    $progressCount['votedForCount'] = ($progressCount['totalCount'] - $progressCount['remainder']);
    break;
    default:
    break;
  }

  if(!$request->has('page')){
    $user=$user->where('id', $groupid);
  }
  $userss=$user->simplePaginate(1);;

  return view('voting.votegrp', compact('userss', 'user', 'voteswitch', 'catlist', 'progressCount'));
}


public function getVotedID($at,$ac){
  return Voting::where(['award_cat'=>$ac,'award_type'=>$at, 'voter_id' => \Auth::user()->id,'year'=> session('FYI')])->groupBy('voted_for_id')->distinct('voted_for_id')->select('voted_for_id')->get()->toArray();
}



///////SENDS EMPLOYEE VOTE TO VOTING TABLE////////////
public function votecandidate(Request $request){
  $url=$this->cleanUrl($request->url,$request->page);
  $page= $request->has('page') ? $request->page+1 : 1;
  if($this->readRudder() != '1'){
    return redirect("$url&page=$page")->with('error','Voting is currently disabled by the admin.');
  }
  $votedfor = $request->input('voted_for_id');
  $voter_id = $request->input('voter_id');
  $at = $request->input('at');
  $ac = $request->input('ac');
  $dd = $request->input('dd');

  foreach ($request->value as $key => $value) {
   $exists=Voting::where('voter_id', $voter_id)->where(['votecat_id'=>$key, 'voted_for_id'=>$votedfor, 'award_cat'=>$ac, 'award_type'=> $at, 'year' => session('FYI')])->first();
   $cadrepercent = (int)$request->input('cadrepercent')[$key];
   $value = (round($value) * $cadrepercent) / 9;
   if ($exists) {
    if($at == '1'){
       return redirect("$url&page=$page")->with('error','You voted that employee already, vote next candidate.');
     }else{
       return redirect("$url&page=$page")->with('error','You voted that team already, vote next candidate.');
     }
   }
   else{
    $obj = new Voting;
    $obj->votecat_id = $key;
    $obj->voter_id = $voter_id;
    $obj->voted_for_id = $votedfor;
    $obj->percentage = $value;
    $obj->year = session('FYI');
    $obj->award_type = $at;
    $obj->award_cat = $ac;
    $obj->save();
  }

}

///////SENDS VOTED EMPLOYEE REPORT TO REPORTING TABLE////////////
foreach ($request->value as $key => $value) {
  $exists2 =VoteReport::where([/*'cadre_id'=> $cadreid,*/ 'votecat_id'=> $key, 'voted_for_id'=> $votedfor, 'award_cat'=> $ac, 'award_type' => $at, 'year' => session('FYI')])->first();

  $cadrepercent = (int)$request->input('cadrepercent')[$key];
  $value = (round($value) * $cadrepercent) / 9;

  if ($exists2) {
    $obj2 = VoteReport::find($exists2->id);
  }
  else{
    $obj2 = new VoteReport;
    $obj2->votecat_id = $key;
    $obj2->voter_id = $voter_id;
  }

  $obj2->voted_for_id = $votedfor;
  if($obj2->total_percentage > 0){
    $obj2->total_percentage = ($obj2->total_percentage + $value);
    $obj2->total_votes = ($obj2->total_votes + 1);
  }
  else{
    $obj2->total_percentage = $value;
    $obj2->total_votes = 1;
    $obj2->year = session('FYI');
    $obj2->award_type = $at;
    $obj2->award_cat = $ac;
  }
  $obj2->save();
}
  return redirect("$url&page=$page")->with('success','You vote have been submited, vote next candidate.');
}


///////DISPLAYS BEST VOTE REPORTS FOR EACH CATEGORY////////////
public function votereport(Request $request){
  $this->StatusCheck();
  $this->permissionCheck('view_result');
  $filters = $request->all();
  $awardcategory = Awards::where('award_type', '<>', 3)->get();
  $departments = \App\job_dep::where('type','dept')->get();
  $units = \App\job_dep::where('type','unit')->orderBy('spec','ASC')->get();
  $fieldoffices = \App\FieldOffice::orderBy('name','ASC')->get();
  $votecat = Vote::get();
  return view('voting.votereport', compact('awardcategory', 'awardtype', 'votecat','filters', 'departments', 'units', 'fieldoffices'));
}


///////DISPLAYS USER VOTE REPORT////////////
public function uservotereport(Request $request, $voted_for_id, $award_cat){
  $this->permissionCheck('view_result');
  $awardcategory = Vote::where('award_cat', $award_cat)->get();
  $user = User::where('id', $voted_for_id)->first();
  $voting = Voting::where('voted_for_id', $voted_for_id)->where('award_cat', $award_cat)->groupBy('voter_id')->get();
  $ac = Awards::where('id', $award_cat)->first();
  return view('voting.uservotereport', compact('voting', 'user', 'awardcategory', 'ac'));
}


private function cleanUrl($url,$page){
  return str_replace("&page=$page",'',$url);
}

///////DISPLAYS ALL USER VOTE REPORTS////////////
public function allusersvotereport(Request $request){
  $this->permissionCheck('view_result');

  $filters = $request->all();
  $awardcategory = Awards::where('award_type', '<>', 3)->get();
  $awardtype = AwardType::get();
  $cadres = \App\Cadre::get();
  $zones = \App\Zone::get();
  $fieldoffices = \App\FieldOffice::get();
  $at = $request->input('awardtype');
  $ac = $request->input('awardcategory');
  $voting = Voting::where('year', session('FYI'))->groupBy('voted_for_id');

  if((isset($at) && $at !='') && (isset($ac) && $ac !='')){
    $voting = $voting->where('award_cat', $ac)->where('award_type', $at);
    $votingcategories = \App\Vote::where('award_cat', $ac)->where('award_type', $at)->get();
  }
  $voting=$voting->get();

  return view('voting.alluservotereport', compact('voting','votingcategories', 'cadres', 'zones', 'fieldoffices', 'voting', 'filters', 'awardcategory', 'awardtype'));
}



public function merit_award(Request $request){
  $this->permissionCheck();
  $filters = $request->all();
  $awardcategory = Awards::where('award_type', '=', 3)->get();
  if(isset($filters['awardcategory']) && $filters['awardcategory']!=''){
    $args = strtolower(VoteAwards::where('id', $filters['awardcategory'])->first()->name);
    $parameter = $str = preg_replace('/\D/', '', $args);
    $parameter = ($parameter);
    $users = User::all();
    $users= $users->where('hire_age', $parameter);
  }else{
    $users = User::get();
  }
  return view('voting.merit-award', compact('users', 'awardcategory'));
}



public function eligibility(Request $request){
  $ac = $request->input('ac');
  if($request->has('opt')){
    if($request->input('opt') == '1'){
      $users = User::whereIn('id',$this->getEligiblesID($ac))->get();
    }else{
     $users = User::whereNotIn('id',$this->getEligiblesID($ac))->get();
   }
 }else{
  $users = NULL;
}
return view('voting.eligibility', compact('users'));
}



public function eligiblevotersmodal(Request $request){
  $ac = $request->input('ac');
  if($request->has('opt')){
      if($request->input('opt') == '1'){
        $users = User::whereIn('id',$this->getEligiblesID($ac))->get();
      }else{
       $users = User::whereNotIn('id',$this->getEligiblesID($ac))->get();
     }
   }else{
    $users = NULL;
  }
  return view('settings.votesettings.modals.eligiblevoter', compact('users'));
}


public function getEligiblesID($ac){
  $tt = VoteEligibility::where(['ac'=> $ac, 'year' => session('FYI')])->pluck('voter_id');
  return $tt;
}



public function eligibility_submit(Request $request){
  $this->permissionCheck();
  $ac = $request->input('ac');
  $dd = $request->input('dd');
  $eligiblity = (array)$request->input('eligible');
  $year = session('FYI');
  $opt = $request->input('opt');
  if(count($eligiblity) > 0){
    if($request->input('action') == 'add'){
      foreach ($eligiblity as $key => $value) {
        $add = VoteEligibility::insert(['voter_id' => $value, 'ac' => $ac, 'year' => $year]);
      }
    }
    elseif($request->input('action') == 'remove'){
      foreach ($eligiblity as $key => $value) {
        $remove = VoteEligibility::where(['voter_id' => $value, 'ac' => $ac, 'year' => $year])->delete();
      }
    }
  }

  request()->request->add(['ac'=>$ac,'dd'=>$dd]);


  if($request->has('opt')){
      if($request->input('opt') == '1'){
        $users = User::whereIn('id',$this->getEligiblesID($ac))->get();
      }else{
       $users = User::whereNotIn('id',$this->getEligiblesID($ac))->get();
     }
   }else{
    $users = NULL;
  }
  return view('settings.votesettings.modals.eligiblevoter', compact('users'));



  //return redirect("eligibility?ac=$ac&dd=$dd&opt=$opt")->with('success','Eligibility list have been updated.');;
}



}
