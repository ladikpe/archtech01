<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    // public function users()
    // {
    //     return $this->belongsToMany('App\Permission');
    // }
    protected $fillable=['permission_category_id','name','constant'];
    public function roles()
    {
        return $this->belongsToMany('App\Role','permission_role','permission_id','role_id');
    }
    public function permissionscategories()
    {
        return $this->belongsToMany('App\PermissionCategory');
    }
}
