<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable =['name','manager_id','a_id'];


    public function manager()
    {
        return $this->belongsTo('App\User','manager_id');
    }
    public function field_offices()
    {
        return $this->hasMany('App\FieldOffice','zone_id');
    }
}
