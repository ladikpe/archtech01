<?php

namespace App\Console\Commands;

use App\AperMeasurementPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class updateaperassessment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aper:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('performance_assessments')->orderBy('id')->chunk(1000, function ($assessment_details) {
            foreach ($assessment_details as $detail) {
                if ($detail->fiscal_year > 0)
                {
                    $measurement_period = \App\AperMeasurementPeriod::whereYear('from', $detail->fiscal_year)->first();
                    if (!$measurement_period) {
                        $measurement_period = AperMeasurementPeriod::create(['from' => date('Y-m-d', strtotime('01-01-' . $detail->fiscal_year)), 'to' => date('Y-m-d', strtotime('31-12-' . $detail->fiscal_year))]);
                    }
                    $assessment=$aper_assessment= \App\AperAssessment::where(['employee_id'=>$detail->user_id,'aper_measurement_period_id'=>$measurement_period->id])->first();
                    if(!$assessment){

                        $assessment=\App\AperAssessment::create(['aper_measurement_period_id'=>$measurement_period->id,'company_id'=>companyId(),
                            'employee_id'=>$detail->user_id,'manager_id'=>$detail->created_by,
                            'score'=>0]);

                    }
                    \App\AperAssessmentDetail::updateOrCreate(['user_id'=>$detail->user_id,'aper_assessment_id'=>$assessment->id,
                        'aper_sub_metric_id'=>$detail->performance_module_id],
                        ['user_id'=>$detail->user_id,'aper_assessment_id'=>$assessment->id,'aper_sub_metric_id'=>$detail->performance_module_id,
                            'created_by'=>$detail->created_by,'updated_by'=>$detail->created_by,'score'=>$detail->score]);

                }


            }
        });
        $this->info('success');
//        return 'success';
    }
}
