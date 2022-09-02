<?php

use Illuminate\Http\Request;
use GuzzleHttp\Client;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/app_key', function (Request $request) {
    return env('APP_KEY');
});
Route::post('navsion_integration/','CompensationController@nav_int');
Route::post('hcrecruit_add_user/','UserController@saveNewHcRecruit');

Route::get('hcrecruit_companies/','UserController@getCompanies');
Route::get('hcrecruit_departments/company_id','UserController@getDepartments');
Route::get('hcrecruit_branches/company_id','UserController@getBranches');
Route::get('hcrecruit_grades','UserController@getGrades');
Route::get('hcrecruit_job_roles/department_id','UserController@getJobRoles');


//biometric api
Route::get('/data', 'BiometricController@data');
Route::get('/iclock/cdata', 'BiometricController@checkDevice');
Route::post('/iclock/cdata', 'BiometricController@receiveRecords');
Route::get('/iclock/getrequest', 'BiometricController@getRequest');
Route::post('/iclock/devicecmd', 'BiometricController@deviceCMD');


Route::get('/iclock/getrequest', 'BiometricController@getrequest');
Route::get('/iclock/devicecmd', 'BiometricController@deviceCMD');


//visitor
Route::get('/visitor/users', 'VisitorApiController@users');
Route::get('/visitor/departments', 'VisitorApiController@departments');
Route::get('/visitor/roles', 'VisitorApiController@roles');

//
Route::get('v1/public/directory', 'UserController@apiUsers');
Route::get('v1/public/directory/{id}', 'UserController@apiUser');

Route::get('/fetch-users', function () {
//     // echo phpinfo();
//     // exit;
//     $exitCode = Artisan::call('fetch:users');
// return 'done';
//     //

   $client = new Client();
        $response=$client->post(
            'https://api.officelime.com:9099/v1/token',
            array(
                'headers' => ['client_id' => 'F58B3E9F-ADA7-4DB0-BE35642622868F78'],
                'form_params' => [
                    'Email' => 'tobe@snapnet.com.ng',
                    'Key' => 'MAdv4k3AN2WgR5ajxVzguOyTh/SStIuA6euQE0sVexryG0l9r8wJa'
                ],'verify' =>false,
                
            )
        );


       $auth_response= json_decode($response->getBody());
      return $token=$auth_response->token;
});