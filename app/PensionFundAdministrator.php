<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PensionFundAdministrator extends Model
{
    protected $fillable =['name'];

    public function users()
    {
        return $this->hasMany('App\User','pension_fund_administrator_id');
    }
}
