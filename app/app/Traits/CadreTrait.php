<?php


namespace App\Traits;



use App\Cadre;
use App\CompanyOrganogram;

use App\Grade;
use App\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait CadreTrait

{
    public function processGet($route,Request $request)
    {
        switch ($route) {

            case 'get_cadre':
                # code...
                return $this->getCadre($request);
                break;
            case 'delete_cadre':
                # code...
                return $this->deleteCadre($request);
                break;
            case 'ranks':
                # code...
                return $this->cadreRanks($request);
                break;
            case 'get_rank':
                # code...
                return $this->getRank($request);
                break;
            case 'delete_rank':
                # code...
                return $this->deleteRank($request);
                break;
            case 'zones':
                # code...
                return $this->zones($request);
                break;
            case 'get_zone':
                # code...
                return $this->get_zone($request);
                break;
            case 'delete_zone':
                # code...
                return $this->delete_zone($request);
                break;
            case 'field_offices':
                # code...
                return $this->field_offices($request);
                break;
            case 'get_field_office':
                # code...
                return $this->get_field_office($request);
                break;
            case 'delete_field_office':
                # code...
                return $this->delete_field_office($request);
                break;

            default:
                # code...
                break;

        }
    }

    public function processPost(Request $request){
        // try{
        switch ($request->type) {

            case 'save_cadre':
                # code...
                return $this->saveCadres($request);
                break;
            case 'save_rank':
                # code...
                return $this->saveRanks($request);
                break;
            case 'rank_positions':
                # code...
                return $this->saveRankPositon($request);
                break;



            default:
                # code...
                break;
        }

    }

    public function getCadre(Request $request)
    {
        return $cadre=Cadre::find($request->cadre_id);
    }

    public function deleteCadre(Request $request)
    {
        $cadre=Cadre::find($request->cadre_id);
        if ($cadre){
            if(!$cadre->ranks){
                $cadre->delete();
                return 'success';
            }

        }
        return 'failed';
    }
    public function saveCadres(Request $request)
    {
        $cadre = Cadre::updateOrCreate(['id'=>$request->cadre_id],['name'=>$request->name,'promotion_type'=>$request->promotion_type]);
        return 'success';
    }

    public function cadreRanks(Request $request){
        $cadre=Cadre::find($request->cadre_id);
        $ranks=Rank::where('cadre_id',$cadre->id)->orderBy('position','asc')->get();
        $grades=Grade::all();
        return view('settings.ranksettings.index',compact('cadre','ranks','grades'));
    }

    public function getRank(Request $request)
    {
        return $rank=Rank::find($request->rank_id);
    }

    public function deleteRank(Request $request)
    {
        $rank=Rank::find($request->rank_id);
        
        if ($rank){
            if($rank->users->count()==0){
                $rank->delete();
                return 'success';
            }

        }
        return 'failed';
    }
    public function saveRankPositon(Request $request)
    {
        foreach ($request->input('positions') as $position) {
            $rank = Rank::find($position[0]);
            $rank->update(['position' => $position[1]]);
        }
        return $request->input('positions');
        return 'success';
    }

    public function saveRanks(Request $request)
    {
        $rank = Rank::updateOrCreate(['id'=>$request->rank_id],['cadre_id'=>$request->cadre_id,'grade_id'=>$request->grade_id,'name'=>$request->name]);
        return 'success';
    }
    public function downloadRankTemplate(Request $request)
    {

        $template = ['Rank name', 'Grade', 'Cadre'];

        $grades = \App\Grade::select('level as level', 'id as Id')->get()->toArray();
        $cadres = \App\Cadre::select('name as name', 'id as Id')->get()->toArray();

        return $this->exportRCexcel('template', ['template' => $template, 'grades' => $grades, 'cadres' => $cadres]);

    }

    public function exportRCexcel($worksheetname, $data)
    {
        return \Excel::create($worksheetname, function ($excel) use ($data) {
            foreach ($data as $sheetname => $realdata) {
                $excel->sheet($sheetname, function ($sheet) use ($realdata, $sheetname) {

                    $sheet->fromArray($realdata);
                    if ($sheetname == 'grades') {

                        $sheet->_parent->addNamedRange(
                            new \PHPExcel_NamedRange(
                                'sd', $sheet->_parent->getSheet(1), "A2:A" . $sheet->_parent->getSheet(1)->getHighestRow()
                            )
                        );

                        for ($j = 2; $j <= 350; $j++) {
                            $objValidation = $sheet->_parent->getSheet(0)->getCell("B$j")->getDataValidation();
                            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $objValidation->setAllowBlank(false);
                            $objValidation->setShowInputMessage(true);
                            $objValidation->setShowErrorMessage(true);
                            $objValidation->setShowDropDown(true);
                            $objValidation->setErrorTitle('Input error');
                            $objValidation->setError('Value is not in list.');
                            $objValidation->setPromptTitle('Pick from list');
                            $objValidation->setPrompt('Please pick a value from the drop-down list.');
                            $objValidation->setFormula1('sd');


                        }
                    }




                    if ($sheetname == 'cadres') {

                        $sheet->_parent->addNamedRange(
                            new \PHPExcel_NamedRange(
                                'sdy', $sheet->_parent->getSheet(2), "A2:A10" . $sheet->_parent->getSheet(1)->getHighestRow()
                            )
                        );

                        for ($j = 2; $j <= 350; $j++) {
                            $objValidation = $sheet->_parent->getSheet(0)->getCell("C$j")->getDataValidation();
                            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $objValidation->setAllowBlank(false);
                            $objValidation->setShowInputMessage(true);
                            $objValidation->setShowErrorMessage(true);
                            $objValidation->setShowDropDown(true);
                            $objValidation->setErrorTitle('Input error');
                            $objValidation->setError('Value is not in list.');
                            $objValidation->setPromptTitle('Pick from list');
                            $objValidation->setPrompt('Please pick a value from the drop-down list.');
                            $objValidation->setFormula1('sdy');


                        }
                    }


                });
            }
        })->download('xlsx');
    }
    public function importRanks(Request $request)
    {
        $document = $request->file('rank_template');


        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        if ($request->hasFile('rank_template')) {

            $datas = \Excel::load($request->file('rank_template')->getrealPath(), function ($reader) {
                $reader->noHeading()->skipRows(1);
            })->get();


            foreach ($datas[0] as $data) {
                // dd($data[0]);
                if ($data[0] && $data[1] > 0) {

                    $cadre = \App\Cadre::where('name', $data[2])->first();
                    $grade = \App\Grade::where('level', $data[1])->first();





                    if ($cadre && $grade) {
                        $rank = \App\Rank::create(['name' => $data[0], 'grade_id' => $grade->id, 'cadre_id' => $cadre->id]);
                    }


                }

            }


            //   $request->session()->flash('success', 'Import was successful!');

            // return back();
            return 'success';
        }

    }

    public function cadre_ranks($cadre_id){
        return $ranks= \App\Rank::where('cadre_id',$cadre_id)->get();

    }
    public function importUserRanks(Request $request)
    {
        $document = $request->file('rank_users');

        $cadre = \App\Cadre::find($request->cadre_id);
        $rank = \App\Rank::find($request->rank_id);


        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        if ($request->hasFile('rank_users') && $cadre && $rank) {

            Excel::load($request->file('rank_users')->getRealPath(), function ($reader) use($cadre,$rank) {


                foreach ($reader->toArray() as $key => $row) {
                    $user=\App\User::where('emp_num',$row['staff_id'])->first();
                    if($user){
                        $user->update(['cadre_id'=>$cadre->id,'rank_id'=>$rank->id]);
                    }



                }
            });
        }
        return 'success';
    }





}
