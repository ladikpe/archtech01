<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\AttendanceDetail;
use App\AttendanceReport;
use App\Biometric;
use App\CommandLog;
use App\Company;
use App\Jobs\ProcessSingleAttendanceJob;
use App\LatenessPolicy;
use App\ManualAttendance;
use App\Setting;
use App\Traits\Attendance as AttendanceTrait;
use App\Traits\BiometricTrait as BiometricTrait;
use App\Traits\FaceMatchTrait as FMT;
use App\User;
use App\UserDailyShift;
use Artisan;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class BiometricController extends Controller
{
    use AttendanceTrait,BiometricTrait,FMT;
    public function data(){


        /* $data="1015\t2020-04-22 07:16:18\t0\t1\t\t0\t0\t\n1034\t2020-04-22 07:52:32\t0\t1\t\t0\t0\t\n1064\t2020-04-22 07:52:32\t0\t1\t\t0\t0\t\n1039\t2020-04-22 09:29:35\t0\t1\t\t0\t0\t\n";

        $serial='111';
        $arr = preg_split('/\\r\\n|\\r|,|\\n/', $data);//user id       //time      //status    //VERIFY          //WORKCODE       //RESERVED1
        foreach ($arr as $a) {
            $totalwords = strlen($a);
            if ($totalwords > 10) {    //if all the required data is inside the received format
                $d = explode("\t", $a);
                $empnum = $d[0];
                //$empnum = '4';
                $time = $d[1];
                $status_id = $d[2];
                $verify_id = $d[3];
                $data = ['emp_num' => $empnum, 'time' => $time, 'status_id' => $status_id, 'verify_id' => $verify_id,'serial'=>$serial];
                $this->saveAttendance($data);
            }
        }*/
       return AttendanceReport::first();
        return 'done';

    }

    public function softClockIn(Request $request){
        $long=$request->long;
        $lat=$request->lat;
        $company_long=Setting::where('name','company_long')->where('company_id',companyId())->first()->value;
        $company_lat=Setting::where('name','company_lat')->where('company_id',companyId())->first()->value;
        $enforce_geofence=Setting::where('name','enforce_geofence')->where('company_id',companyId())->first()->value;
        $distance=Setting::where('name','distance')->where('company_id',companyId())->first()->value;
        if ($enforce_geofence==1){
            $cood_distance=$this->getDistanceFromLatLngInKm(['latitude'=>$company_lat,'longitude'=>$company_long],
                ['latitude'=>$lat,'longitude'=>$long]);
            if ($cood_distance>$distance){
                return 'Not within Company Geofence';
            }
        }
        $user=User::find(Auth::id());
        $now=Carbon::now()->format('Y-m-d H:i:s');
        $data = ['emp_num' => $user->emp_num, 'time' => $now, 'status_id' => 0, 'verify_id' => 1,'serial'=>00,'long'=>$long,'lat'=>$lat];
        $this->saveAttendance($data);
        return 'Successfully Clocked In!';
    }
    public function softClockOut(Request $request){
        $long=$request->long;
        $lat=$request->lat;
        $company_long=Setting::where('name','company_long')->where('company_id',companyId())->first()->value;
        $company_lat=Setting::where('name','company_lat')->where('company_id',companyId())->first()->value;
        $enforce_geofence=Setting::where('name','enforce_geofence')->where('company_id',companyId())->first()->value;
        $distance=Setting::where('name','distance')->where('company_id',companyId())->first()->value;
        if ($enforce_geofence==1){
            $cood_distance=$this->getDistanceFromLatLngInKm(['latitude'=>$company_lat,'longitude'=>$company_long],
                ['latitude'=>$lat,'longitude'=>$long]);
            if ($cood_distance>$distance){
                return 'Not within Company Geofence';
            }
        }
        $user=User::find(Auth::id());
        $now=Carbon::now()->format('Y-m-d H:i:s');
        $data = ['emp_num' => $user->emp_num, 'time' => $now, 'status_id' => 1, 'verify_id' => 1,'serial'=>00,'long'=>$long,'lat'=>$lat];
        $this->saveAttendance($data);
        return 'Successfully Clocked Out!';
    }
    public function enrollUsers(){
        $company_id = companyId();
        if (isset(Company::find($company_id)->biometric_serial)){
            $users=User::where('company_id',$company_id)->whereIn('status',[0,1])->get();
            $this->createMultipleUsers($users);
        }
        return Redirect::back();
    }
    public function removeUsers(){
        $company_id = companyId();
        if (isset(Company::find($company_id)->biometric_serial)){
            $users=User::where('company_id',$company_id)->get();
            $this->deleteMultipleUsers($users);
        }
        return Redirect::back();
    }

    public function checkDevice(Request $request)
    {
        $this->savetoTable($request);
        $last = Biometric::orderBy('id', 'ASC')->first();
        if ($last) {
            $time = $last->created_at->timestamp;
        } else {
            $time = now()->timestamp;
        }
        //$contents="C:18:DATA USER PIN=22\tName=Soladoye\tPasswd=1234\tCard=123456\tPri=0";
        $log= CommandLog::where('biometric_serial',$request->SN)->orderBy('id','desc')->first();
        if ($log){
            $command=$log->command;
        }
        $command = "GET OPTION FROM:%s{$request->SN}\nStamp=1565089939\nOpStamp=1565089939\nErrorDelay=30\nDelay=10\nTransTimes=00:00;14:05\nTransInterval=1\nTransFlag=1111000000\nTimeZone=1\nRealtime=1\nEncrypt=0\n";
        return $this->commandresponse($command);
    }

    public function getRequest(Request $request)
    {
        //this is the second thing that gets called on device start up. You send OK if it you dont have any command to send
        $serial_number=$request->SN;
        return $this->commandToSend($serial_number);
    }

    //once a successful command request is made, the device makes a call to deviceCMD
    public function deviceCMD(Request $request)
    {
        $data=$request->getContent();
        $arr = preg_split('/\\r\\n|\\r|,|\\n/', $data);
        $return_data=[];
        foreach ($arr as $a) {
            $totalwords = strlen($a);
            if ($totalwords > 10) {    //if all the required data is inside the received format
                $d = explode("&", $a);
                $id = $d[0];
                $status=$d[1];
                $id_length=strlen($id);
                $position=strpos($id,'ID=');
                $end=$id_length-$position;
                $real_id=substr($id, $position+3, $end);

                $status_length=strlen($status);
                $position2=strpos($status,'Return=');
                $end2=$status_length-$position2;
                $real_status=substr($status, $position2+7, $end2);
                $return_data[] = ['id' => $real_id, 'status' => $real_status];
            }
        }
        $this->updateLogOnReturn($return_data);
        $this->savetoTable($request);
        return $this->returnOk();
    }
    public function receiveRecords(Request $request)
    {
        if (isset($request->table)) {
            $table = $request->table;
        } else {
            $this->doNothing();
        }
        switch ($table) {
            case 'ATTLOG':
                $this->savetoTable($request);
                $this->logAttendance($request);

                return $this->returnOk();
                break;
            case 'ATTPHOTO':
                //receiveOnSitePhoto($request);
                break;
            case 'OPERLOG':
                //ureceiveUserInfo($request);
                break;
            default:
                $this->doNothing();
                break;
        }
        return $this->returnOk();
    }

    private function logAttendance(Request $request)
    {
        $serial=$request->SN;
        $data = $request->getContent();
        $arr = preg_split('/\\r\\n|\\r|,|\\n/', $data);//user id       //time      //status    //VERIFY          //WORKCODE       //RESERVED1
        foreach ($arr as $a) {
            $totalwords = strlen($a);
            if ($totalwords > 10) {    //if all the required data is inside the received format
                $d = explode("\t", $a);
                $empnum = $d[0];
                //$empnum = '4';
                $time = $d[1];
                $status_id = $d[2];
                $verify_id = $d[3];
                $data = ['emp_num' => $empnum, 'time' => $time, 'status_id' => $status_id, 'verify_id' => $verify_id,'serial'=>$serial];
                $this->saveAttendance($data);
            }
        }

    }

    private function doNothing()
    {

    }


    private function savetoTable(Request $request)
    {
        $new = new Biometric();
        $new->headers = $request->header();
        $new->url = $request->getMethod() . '- ' . $request->fullUrl();
        $new->data = $request->getContent();
        $new->save();
    }

}
