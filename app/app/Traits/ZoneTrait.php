<?php


namespace App\Traits;



use App\User;
use App\Zone;

use App\FieldOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait ZoneTrait

{
    public function processGet($route,Request $request)
    {
        switch ($route) {

            case 'get_zone':
                # code...
                return $this->getZone($request);
                break;
            case 'delete_zone':
                # code...
                return $this->deleteZone($request);
                break;
            case 'field_offices':
                # code...
                return $this->zoneFieldOffices($request);
                break;
            case 'get_field_office':
                # code...
                return $this->getFieldOffice($request);
                break;
            case 'delete_field_office':
                # code...
                return $this->deleteFieldOffice($request);
                break;


            default:
                # code...
                break;

        }
    }

    public function processPost(Request $request){
        // try{
        switch ($request->type) {

            case 'save_zone':
                # code...
                return $this->saveZones($request);
                break;
            case 'save_field_office':
                # code...
                return $this->saveFieldOffices($request);
                break;




            default:
                # code...
                break;
        }

    }

    public function getZone(Request $request)
    {
        return $zone=Zone::find($request->zone_id);
    }

    public function deleteZone(Request $request)
    {
        $zone=Zone::find($request->zone_id);
        if ($zone){
            if(!$zone->field_offices->count()>0){
                $zone->delete();
                return 'success';
            }

        }
        return 'failed';
    }
    public function saveZones(Request $request)
    {
        $zone = Zone::updateOrCreate(['id'=>$request->zone_id],['name'=>$request->name,'manager_id'=>$request->manager_id]);
        return 'success';
    }

    public function zoneFieldOffices(Request $request){
        $zone=Zone::find($request->zone_id);
        $zones=Zone::all();
        $field_offices=FieldOffice::where('zone_id',$zone->id)->get();
        $users=User::all();
        return view('settings.fieldofficesettings.index',compact('zone','field_offices','users','zones'));
    }

    public function getFieldOffice(Request $request)
    {
        return $field_office=FieldOffice::find($request->field_office_id);
    }

    public function deleteFieldOffice(Request $request)
    {
        $field_office=FieldOffice::find($request->field_office_id);
        if ($field_office){
            if(!$field_office->users->count()>0){
                $field_office->delete();
                return 'success';
            }

        }
        return 'failed';
    }


    public function saveFieldOffices(Request $request)
    {
        $field_office = FieldOffice::updateOrCreate(['id'=>$request->field_office_id],['zone_id'=>$request->zone_id,'manager_id'=>$request->manager_id,'name'=>$request->name]);
        return 'success';
    }
    public function downloadFieldOfficeTemplate(Request $request)
    {

        $template = ['FieldOffice name', 'Grade', 'Zone'];

        $grades = \App\Grade::select('level as level', 'id as Id')->get()->toArray();
        $zones = \App\Zone::select('name as name', 'id as Id')->get()->toArray();

        return $this->exportRCexcel('template', ['template' => $template, 'grades' => $grades, 'zones' => $zones]);

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




                    if ($sheetname == 'zones') {

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
    public function importFieldOffices(Request $request)
    {
        $document = $request->file('field_office_template');


        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        if ($request->hasFile('field_office_template')) {

            $datas = \Excel::load($request->file('field_office_template')->getrealPath(), function ($reader) {
                $reader->noHeading()->skipRows(1);
            })->get();


            foreach ($datas[0] as $data) {
                // dd($data[0]);
                if ($data[0] && $data[1] > 0) {

                    $zone = \App\Zone::where('name', $data[2])->first();
                    $grade = \App\Grade::where('level', $data[1])->first();





                    if ($zone && $grade) {
                        $field_office = \App\FieldOffice::create(['name' => $data[0], 'grade_id' => $grade->id, 'zone_id' => $zone->id]);
                    }


                }

            }


            //   $request->session()->flash('success', 'Import was successful!');

            // return back();
            return 'success';
        }

    }

    public function zone_field_offices($zone_id){
        return $field_offices= \App\FieldOffice::where('zone_id',$zone_id)->get();

    }
    public function importUserFieldOffices(Request $request)
    {
        $document = $request->file('field_office_users');

        $zone = \App\Zone::find($request->zone_id);
        $field_office = \App\FieldOffice::find($request->field_office_id);


        //$document->getRealPath();
        // return $document->getClientOriginalName();
        // $document->getClientOriginalExtension();
        // $document->getSize();
        // $document->getMimeType();


        if ($request->hasFile('field_office_users') && $zone && $field_office) {

            Excel::load($request->file('field_office_users')->getRealPath(), function ($reader) use($zone,$field_office) {


                foreach ($reader->toArray() as $key => $row) {
                    $user=\App\User::where('emp_num',$row['staff_id'])->first();
                    if($user){
                        $user->update(['zone_id'=>$zone->id,'field_office_id'=>$field_office->id]);
                    }



                }
            });
        }
        return 'success';
    }





}
