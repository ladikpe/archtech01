<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    protected $fillable=['title','posting_type_id','effective_date','file','user_id','workflow_id','approval_status','comment','created_by','location'];
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(new CompanyScope);
    // }

    public function posting_type()
    {
        return $this->belongsTo('App\PostingType','posting_type_id');
    }
    public function posting_approvals()
    {
        return $this->hasMany('App\PostingApproval','posting_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function creator()
    {
        return $this->belongsTo('App\User','created_by');
    }
    public function workflow()
    {
        return $this->belongsTo('App\Workflow','workflow_id');
    }
}
