<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorBlacklist extends Model
{
    protected $fillable=['user_id','visitor_id','reason','status'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function visitor(){
        return $this->belongsTo('App\Visitor');
    }
}
