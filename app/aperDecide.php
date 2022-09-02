<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class aperDecide extends Model
{
    //
    protected $fillable =['action','comment','fy','emp_id'];

 

    public function getresolveActionAttribute(){
    	switch ($this->action) {
    		case 0:
    				return 'Pending';
    			# code...
    			break;
    		case 1:
    				return 'Approved';
    			# code...
    			break;
    		default:
    				return 'Rejected';
    			# code...
    			break;
    	}
    }
}
