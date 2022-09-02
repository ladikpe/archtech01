<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;



class SpecificSalaryComponentType extends Model
{
	protected $table='specific_salary_component_types';
    protected $fillable=['name','display','company_id'];
   
    public function specific_salary_components()
    {
        return $this->hasMany('App\SpecificSalaryComponent','specific_salary_component_type_id');
    }
   
    protected static function boot()
    {
        parent::boot();      
        static::addGlobalScope(new CompanyScope);
    }
}
