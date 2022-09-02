<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionLog extends Model
{
    protected $fillable=['user_id','old_rank_id','new_rank_id','approved_by','promotion_date'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function approved(){
        return $this->belongsTo('App\User');
    }
}
