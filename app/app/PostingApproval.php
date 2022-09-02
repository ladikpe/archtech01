<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostingApproval extends Model
{
    protected $fillable=['posting_id','stage_id','approver_id','comments','status'];
    public function posting()
    {
        return $this->belongsTo('App\Posting','posting_id');
    }

    public function approver()
    {
        return $this->belongsTo('App\User','approver_id');
    }
    public function stage()
    {
        return $this->belongsTo('App\Stage','stage_id');
    }
}
