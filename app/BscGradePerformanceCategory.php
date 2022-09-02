<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BscGradePerformanceCategory extends Model
{
   protected $fillable = ['name'];
   protected $table="bsc_grade_performance_categories";

   public function grades()
    {
       return $this->hasMany('App\Grade','bsc_grade_performance_category_id');
    }
}
