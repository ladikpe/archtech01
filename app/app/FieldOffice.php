<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldOffice extends Model
{
    protected $fillable =['name','zone_id','manager_id','a_id'];

    public function zone()
    {
        return $this->belongsTo('App\Zone','zone_id');
    }
    public function manager()
    {
        return $this->belongsTo('App\User','manager_id');
    }

    public function users()
    {
        return $this->hasMany('App\User','field_office_id');
    }
}
