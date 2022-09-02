<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class job_dep extends Model
{
	
	protected $table = 'job_deps';
	protected $fillable=['spec','parent_id','type'];

	protected $appends=['name'];

 //
 
 	public function jobs(){
    	return $this->hasMany('App\job','jobdep_id');
    }

    public function getNameAttribute(){
    	return $this->spec;
    }

    public function getDepartmentAttribute(){
    	 
    	return $this->where('id',$this->parent_id)->value('spec');
    }


}
