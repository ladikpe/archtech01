<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\job;
use App\Repositories\Traits\VoteCategoryTrait;
class Vote extends Model
{
    //
    use VoteCategoryTrait;

	protected $table = 'voteattr';
	protected $fillable = [
		'id',
		'name'
	];


}
