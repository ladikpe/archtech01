<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteJob extends Model
{
    //
    protected $table='vote_jobs';

    protected $fillable=['title','description','jobdep_id','cadre_id'];

    public function department(){
        return $this->belongsTo('App\job_dep','jobdep_id');
    }

    function cadre(){
        return $this->belongsTo('App\Cadre','cadre_id');
    }

    static function search($search='',$limit=7){

        return job::where('title','LIKE',"%$search%")->select('id as id','title as text')->take($limit)->get();

    }

}
