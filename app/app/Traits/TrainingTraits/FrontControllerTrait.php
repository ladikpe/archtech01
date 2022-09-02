<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28/05/2020
 * Time: 01:28
 */

namespace App\Traits\TrainingTraits;


use App\ClassMaps\Kernel;

trait FrontControllerTrait
{

    function runCommand($cmd){
        $cmd = strtolower($cmd);
        $r = explode('-',$cmd);
        $r = array_map(function($v){
            return ucfirst($v);
        },$r);
        if (isset($r[0])){
            $r[0] = strtolower($r[0]);
        }

        $method = implode('',$r);
        if (method_exists($this,$method)){
            return call_user_func_array([$this,$method],[]);
        }else{
            return [
                'message'=>'404 Not Found',
                'error'=>true
            ];
        }

    }

    function runAutomatedCommand($combo){

        $classMap = new Kernel;
        $classMap->loadMaps();

        $combo = explode(':',$combo);

        if (count($combo) <= 1){
            return redirect()->back()->with([
                'message'=>'Invalid Action!',
                'error'=>true
            ]);
        }

        $className = $combo[0];
        $classMethod = $combo[1];

        if (!$classMap->hasClassMap($className)){
            return redirect()->back()->with([
                'message'=>'Invalid Action Query!',
                'error'=>true
            ]);
        }

        $className = $classMap->getClassMap($className);

        $obj = new $className;

        if (!method_exists($obj,$classMethod)){
            return redirect()->back()->with([
                'message'=>'Invalid Action Query Method!',
                'error'=>true
            ]);
        }

        $response = call_user_func_array([$obj,$classMethod],[]);

        return redirect()->back()->with($response)->withInput();

    }


}