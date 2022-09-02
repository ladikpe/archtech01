<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wallet extends Model
{
    //
    protected $fillable=['name','lock_code','currency','user_ref','created_by','amount','wallet_id'];
}
