<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ZoneTrait;
use App\Zone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ZoneTrait;
    public function index()
    {

        $zones=\App\Zone::all();
        $users=\App\User::all();

        return view('settings.zonesettings.index',compact('zones','users'));
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
