<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable=['name','email','phone','status','users','restriction'];

    public function visits(){
        return $this->hasMany('App\Visit');
    }
    public function blacklist_requests(){
        return $this->hasMany('App\BlacklistRequest');
    }
    protected $casts=[
        'users'=>'array',
    ];
}
