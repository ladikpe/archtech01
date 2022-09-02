<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceSubject extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'performance_subjects';
    protected $fillable = ['name','created_by','fillable'];

    public function user()
	{
	    return $this->belongsTo('App\User', 'created_by');
	}

	public function performance_modules(){
		return $this->hasMany('App\PerformanceModule', 'performance_subject_id');
	}
}