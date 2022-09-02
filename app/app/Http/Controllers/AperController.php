<?php

namespace App\Http\Controllers;

use App\Traits\AperTrait;
use http\Env\Response;
use Illuminate\Http\Request;


class AperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use AperTrait;
    public function index()
    {
        $measurement_periods=\App\AperMeasurementPeriod::all();

        return view('aper.index',compact('measurement_periods'));
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
