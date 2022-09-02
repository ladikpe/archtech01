<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteAwards extends Model
{
    protected $table = 'voteawards';
    protected $fillables = ['name'];
}
