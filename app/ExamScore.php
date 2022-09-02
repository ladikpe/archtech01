<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamScore extends Model
{
    protected $fillable=['user_id','score','year','status'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
