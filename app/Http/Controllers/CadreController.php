<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CadreTrait;
use App\Cadre;

class CadreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use CadreTrait;
    public function index()
    {

        $cadres=\App\Cadre::orderBy('name','asc')->get();

        return view('settings.cadresettings.index',compact('cadres'));
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
