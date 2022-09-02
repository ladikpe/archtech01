<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable =['name','department_id','manager_id','a_id'];

    public function department()
    {
        return $this->belongsTo('App\Department','department_id');
    }
    public function manager()
    {
        return $this->belongsTo('App\User','manager_id');
    }

    public function users()
    {
        return $this->hasMany('App\User','user_id');
    }
}
