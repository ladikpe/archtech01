<?php

namespace App\Http\Controllers;

use App\Traits\AperSettingTrait;
use Illuminate\Http\Request;
use App\Traits\ZoneTrait;
use App\PensionFundAdministrator;

class AperSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use AperSettingTrait;
    public function index()
    {

        $metrics=\App\AperMetric::all();
        $measurement_periods=\App\AperMeasurementPeriod::all();

        return view('settings.apersettings.index',compact('metrics','measurement_periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        return $this->processPost($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        return $this->processGet($id,$request);
    }
}
