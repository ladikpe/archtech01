<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cadre extends Model
{
    protected $fillable =['name','promotion_type'];

    public function ranks()
    {
        return $this->hasMany('App\Rank','cadre_id');

    }
    public function users()
    {
        return $this->hasMany('App\User','rank_id');

    }

    function budget(){
    	return $this->hasMany(TrTrainingBudget::class,'cadre_id');
    }
}
