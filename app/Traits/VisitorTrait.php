<?php
/**
 * Created by PhpStorm.
 * User: TimothySoladoye
 * Date: 2/4/2020
 * Time: 4:20 PM
 */

namespace App\Traits;

use App\VisitLog;
use App\Mail\SendMail;
use App\Visit;
use App\Visitor;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

trait VisitorTrait
{

    public function emailBlacklistCheck($email,$user)
    {
        $visitor=Visitor::where('email',$email)->first();
        if ($visitor) {
            if ($visitor->restriction=='all'){
                return true;
            }
            if ($visitor->restriction=='users' && in_array($user,$visitor->users)){
                return true;
            }
            return false;
        }
        return false;
    }

    public function phoneBlacklistCheck()
    {
        return true;
    }

    public function sendEmailMethod($from, $to, $subject,$data, $view)
    {
        Mail::to($to)->send(new SendMail($from,$subject,$data,$view));
    }

    public function sendSMS($message,$recipient,$sender)
    {

    }

    public function generateCode(){
        do
        {
            $ss=Str::random(7);
            $random= strtoupper($ss);
            $check=Visit::where('code',$random)->first();
        }
        while(!empty($check));
        return $random;
    }

    public function isHost($visit,$user_id){
        $visit=Visit::find($visit);
        return $visit->user_id==$user_id;
    }

    public function addToLog($visit_id,$status,$date,$message){
        $new=new VisitLog();
        $new->visit_id=$visit_id;
        $new->status=$status;
        $new->message=$message;
        $new->date=$date;
        $new->save();


    }
}