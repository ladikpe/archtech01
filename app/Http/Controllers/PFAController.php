<?php

namespace App\Http\Controllers;

use App\Traits\PFATrait;
use Illuminate\Http\Request;
use App\Traits\ZoneTrait;
use App\PensionFundAdministrator;

class PFAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use PFATrait;
    public function index()
    {

        $pfas=\App\PensionFundAdministrator::all();

        return view('settings.pfasettings.index',compact('pfas'));
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
