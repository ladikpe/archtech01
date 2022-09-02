<?php


namespace App\Traits;



use App\PensionFundAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait PFATrait

{
    public function processGet($route,Request $request)
    {
        switch ($route) {

            case 'get_pfa':
                # code...
                return $this->get_pfa($request);
                break;
            case 'delete_pfa':
                # code...
                return $this->delete_pfa($request);
                break;

            default:
                # code...
                break;

        }
    }

    public function processPost(Request $request){
        // try{
        switch ($request->type) {

            case 'save_pfa':
                # code...
                return $this->save_pfas($request);
                break;

            default:
                # code...
                break;
        }

    }

    public function get_pfa(Request $request)
    {
        return $pfa=PensionFundAdministrator::find($request->pfa_id);
    }

    public function delete_pfa(Request $request)
    {
        $pfa=PensionFundAdministrator::find($request->pfa_id);
        if ($pfa){
            if(!$pfa->users){
                $pfa->delete();
                return 'success';
            }

        }
        return 'failed';
    }
    public function save_pfas(Request $request)
    {
        $pfa = PensionFundAdministrator::updateOrCreate(['id'=>'pfa_id'],['name'=>$request->name]);
        return 'success';
    }


}
