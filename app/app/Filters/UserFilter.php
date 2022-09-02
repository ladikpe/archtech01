<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class UserFilter
{
    public static function apply(Request $filters)
    {
        $user = (new User)->newQuery();

        // Search for a user based on their email. Add q to support select 2
        if ($filters->filled('employee') || $filters->filled('q')) {

          $q= $filters->filled('employee') ? $filters->input('employee') : $filters->input('q');
            $user->where(function ($query) use($q) {
                $query->where('email','like' ,'%' . $q . '%')
                      ->orWhere('name','like' ,'%' . $q . '%')
                      ->orWhere('emp_num','like' ,'%' . $q . '%');
            });

        }
       if ($filters->filled('company')&&$filters->input('company')!=0) {

            $user->where('company_id','=' ,$filters->input('company'));
        }
        if ($filters->filled('department')&&$filters->input('department')!=0) {
          $department_id=$filters->input('department');
        //     $user->whereHas('job.department', function ($query) use($department_id){
        //           $query->where('departments.id', '=', $department_id);
        //       });
         $user->where('department_id','=' ,$department_id);
        }
        if ($filters->filled('division')&&$filters->input('division')!=0) {
          $division_id=$filters->input('division');
       
         $user->where('division_id','=' ,$division_id);
        }

        if($filters->filled('zone') && $filters->input('zone')!=0){
             $zone_id=$filters->input('zone');
            $user->whereHas('field_office.zone', function ($query) use($zone_id){
                  $query->where('zones.id', '=', $zone_id);
              });
            
        }
     
        if($filters->filled('cadre') && $filters->input('cadre')!=0){
             $cadre_id=$filters->input('cadre');
            $user->whereHas('rank.cadre', function ($query) use($cadre_id){
                  $query->where('cadres.id', '=', $cadre_id);
              });
            
        }
        if ($filters->filled('rank')&&$filters->input('rank')!=0) {
            $user->where('rank_id','=' ,$filters->input('rank'));
          }
          if ($filters->filled('field_office')&&$filters->input('field_office')!=0) {
            $user->where('field_office_id','=' ,$filters->input('field_office'));
          }
       //  if ($filters->filled('branch')&&$filters->input('branch')!=0) {
       //      $user->where('branch_id','=' ,$filters->input('branch'));
       //  }
          // Search for a user based on their role.

          if ($filters->filled('role')&&$filters->input('role')!=0) {
            $user->where('role_id','=' ,$filters->input('role'));
          }
          if ($filters->filled('status')&&($filters->input('status')!=''||($filters->input('status')!=3))) {
            $user->where('status','=' ,$filters->input('status'));
          }

        // Search for a user based on their group date.
          if ($filters->filled('user_group')&&$filters->input('user_group')!=0) {
            $q=$filters->input('user_group');
            $user->whereHas('user_groups', function ($query) use($q){
                  $query->where('group_id', '=', $q);
              });
          }

             $company_id=companyId();
           if ($company_id>0) {
                $user->where('company_id', $company_id)->paginate(10);
            }
        // Get the results and return them.
          if ($filters->filled('pagi')&&$filters->input('pagi')=='all') {
            return $user->paginate(2000);
          } elseif(($filters->filled('pagi')&&$filters->input('pagi')==10)||($filters->filled('pagi')&&$filters->input('pagi')==15)||($filters->filled('pagi')&&$filters->input('pagi')==25)||($filters->filled('pagi')&&$filters->input('pagi')==50)){
           return $user->paginate($filters->input('pagi'));
          }

          if (Auth::User()->role->manages=="dr") {
            $manager=Auth::User();
            $user->whereHas('managers',function ($query) use($manager) {
                $query->where('users.id',$manager->id);
            });
          }
          if(request()->has('select2')){
              if(strlen($filters->q)>=3) {
//                  dd('d');
                  return \App\User::where('email','like' ,'%' . $q . '%')
                      ->orWhere('name','like' ,'%' . $q . '%')
                      ->orWhere('emp_num','like' ,'%' . $q . '%')->select('id', 'name as text','probation_period','hiredate','company_id')->skip(0)->take(30)->get();
              }
              return [];
          }
        return $user->orderByDesc('created_at')->paginate(10);

        }


    }
