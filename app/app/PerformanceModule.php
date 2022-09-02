<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceModule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'performance_modules';
    protected $fillable = ['name','created_by','performance_subject_id','editable','emp_id'];

    public function user()
	{
	    return $this->belongsTo('App\User', 'created_by');
	}
	public function performance_subject()
	{
	    return $this->belongsTo('App\PerformanceSubject', 'performance_subject_id');
	}
}