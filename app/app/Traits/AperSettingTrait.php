<?php


namespace App\Traits;



use App\AperMeasurementPeriod;
use App\AperMetric;
use App\AperSubMetric;
use App\PensionFundAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait AperSettingTrait

{
    public function processGet($route,Request $request)
    {
        switch ($route) {

            case 'get_aper_metric':
                # code...
                return $this->get_aper_metric($request);
                break;
            case 'delete_aper_metric':
                # code...
                return $this->delete_aper_metric($request);
                break;
            case 'get_aper_measurement_period':
                # code...
                return $this->get_aper_measurement_period($request);
                break;
            case 'delete_aper_measurement_period':
                # code...
                return $this->delete_aper_measurement_period($request);
                break;
            case 'aper_sub_metrics':
                # code...
                return $this->aper_sub_metrics($request);
                break;
            case 'get_aper_sub_metric':
                # code...
                return $this->get_aper_sub_metric($request);
                break;
            case 'delete_aper_sub_metric':
                # code...
                return $this->delete_aper_sub_metric($request);
                break;

            default:
                # code...
                break;

        }
    }


    public function processPost(Request $request){
        // try{
        switch ($request->type) {

            case 'save_aper_metrics':
                # code...
                return $this->save_aper_metrics($request);
                break;
            case 'save_aper_sub_metrics':
                # code...
                return $this->save_aper_sub_metrics($request);
                break;
            case 'save_aper_measurement_periods':
                # code...
                return $this->save_aper_measurement_periods($request);
                break;
            case 'save_aper_editable_sub_metric':
                # code...
                return $this->save_aper_editable_sub_metric($request);
                break;

            default:
                # code...
                break;
        }

    }

    public function get_aper_metric(Request $request)
    {
        return $am=AperMetric::find($request->am_id);
    }

    public function delete_aper_metric(Request $request)
    {
        $am=AperMetric::find($request->am_id);
        if ($am){
            if(!$am->sub_metrics){
                $am->delete();
                return 'success';
            }

        }
        return 'failed';
    }
    public function save_aper_metrics(Request $request)
    {
        $am=AperMetric::find($request->am_id);
        if ($am){
            $am->update(['name'=>$request->name,'fillable'=>$request->fillable,'updated_by'=>Auth::user()->id]);
        }else{
            $am = AperMetric::create(['name'=>$request->name,'fillable'=>$request->fillable,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id]);
        }

        return 'success';
    }
    public function aper_sub_metrics(Request $request)
    {
        $metric=AperMetric::find($request->am_id);
         $submetrics=AperSubMetric::where(['aper_metric_id'=>$request->am_id])->get();
         return view('settings.apersettings.submetric',compact('submetrics','metric'));
    }
    public function get_aper_sub_metric(Request $request)
    {
        return $asm=AperSubMetric::find($request->asm_id);
    }


    public function delete_aper_sub_metric(Request $request)
    {
        $asm=AperSubMetric::find($request->asm_id);
        if ($asm){
            if($asm->assessment_details->count()>0){
                return 'failed';
            }else{
                $asm->delete();
                return 'success';
            }

        }

    }
    public function save_aper_sub_metrics(Request $request)
    {
        $asm=AperSubMetric::find($request->asm_id);
        if ($asm){
            $asm->update(['name'=>$request->name,'updated_by'=>Auth::user()->id]);
        }else{
            $asm = AperSubMetric::create(['aper_metric_id'=>$request->am_id,'name'=>$request->name,'editable'=>$request->editable,'user_id'=>$request->user_id,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id]);
        }

        return 'success';
    }
    public function save_aper_editable_sub_metric(Request $request)
    {
        $asm=AperSubMetric::find($request->sub_metric_id);
        if ($asm){
            $asm->update(['name'=>$request->name,'updated_by'=>Auth::user()->id]);
        }else{
            $asm = AperSubMetric::create(['aper_metric_id'=>$request->metric_id,'name'=>$request->name,'editable'=>$request->editable,'user_id'=>$request->user_id,'created_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id]);
        }

        return 'success';
    }
    public function get_aper_measurement_period(Request $request)
    {
        return $measurementperiod= AperMeasurementPeriod::find($request->mp_id);
    }

    public function delete_aper_measurement_period(Request $request)
    {
        $measurement_period= AperMeasurementPeriod::find($request->mp_id);
        if ($measurement_period) {
            if (count($measurement_period->assessments)) {
                return 'failed';
            }else{
                $measurement_period->delete();
            }return 'success';
        }else{
            return 'notfound';
        }
    }
    public function save_aper_measurement_periods(Request $request)
    {
        $month=date('m',strtotime('01-'.$request->to));
        $year=date('Y',strtotime('01-'.$request->to));
        $days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
        AperMeasurementPeriod::updateOrCreate(['id'=>$request->mp_id],['from'=>date('Y-m-d',strtotime('01-'.$request->from)),'to'=>date('Y-m-d',strtotime($days.'-'.$request->to))]);
        return 'success';
    }


}
