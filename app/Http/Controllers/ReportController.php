<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use App\Traits\Micellenous;


class ReportController extends Controller
{
	// use Micellenous;
    //
    public function __construct()
	{
	    $this->middleware('auth');
        $this->middleware('microsoft');
	}


	//UPSTREAM REPORT
	public function index()
	{	        	
		return view('report.upstream.index');
	}

	


	//POWER BI Quick insight 
	public function getReport(Request $request)
    {
   
    	


        
   $accessToken=$this->plugPowerBI();

        $dataSetId=env('QI_DATASETID','');

        // $group_ids = "813c11e1-bdcd-4538-95da-ebb415e4d94e";
        $group_ids = "2eac6a98-26bc-40cb-a6c0-e133c53b7038";
 
 		//UPSTREAM
        if($request->page=='demographics')
        {
            
            $groupId = $group_ids;            $reportId="dbbfa75c-9ad2-463b-a07c-50ed084fe621"; 
        }
        
         $accessToken=$this->plugPowerBI();            
         $groupId=env('QI_GROUPID','');
        



        // elseif($request->page=='quickinsight')
        // {
        //     $accessToken=$this->QuickInsight();            $groupId=env('QI_GROUPID','');
        // }
        
        //   	return \Auth::user()->role;

        return view('executiveview.index', compact('accessToken', 'groupId', 'reportId', 'dataSetId', 'page'));
    }

    public function QuickInsight(){
    $groupId=env('QI_GROUPID','');
    $dataSetId=env('QI_DATASETID','');
    $response = \Curl::to("https://api.powerbi.com/v1.0/myorg/groups/$groupId/datasets/$dataSetId/GenerateToken")
                            ->withHeader('Authorization:Bearer '.$this->plugPowerBI())
                            ->withData(['accessLevel'=>'view'])
                            ->asJson()
                            ->post();
                          
// 572f20f0-947c-42b4-a2e4-2faa5a18a786/datasets/d8340c85-6c25-43c6-b1fd-9198f48b9403
                       
    return $response->token;


        }

 public function plugPowerBI(){

    $auth_data= [ 'grant_type'=>'password',
                  'client_id'=>env('POW_CLIENT_ID','') ,
                  'client_secret'=> env('POW_CLIENT_SECRET',''),
                  'resource'=>'https://analysis.windows.net/powerbi/api',
                  'username'=> env('POW_USERNAME',''),
                  'password'=> env('POW_PASSWORD',''),
                  'scope'=>'openid'
        
             ];
    // if(session()->has('access_token') && session('access_token')!=''){
    //         return session('access_token');
    //     }
    $response = \Curl::to('https://login.microsoftonline.com/snapnet.com.ng/oauth2/token')
                        ->withData($auth_data)
                        ->post();
        $response= json_decode($response);
        // dd($response);
      if(!isset($response->access_token)){
        // \Auth::logout();
                                   
       return 'Error';
      
      }
    //   session(['access_token'=>$response->access_token]);
      return $response->access_token;
           
      //$response->access_token;
    }


	
}


