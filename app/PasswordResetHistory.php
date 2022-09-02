<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResetHistory extends Model
{
  protected $fillable = ['user_id','reset_by'];

   
    public function user()
    {
      return $this->belongsToMany('App\User','user_id');
    }
    
    public function reseter()
    {
      return $this->belongsToMany('App\User','reset_by');
    }
    
}
