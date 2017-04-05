<?php
/**
 * Created by PhpStorm.
 * User: jaynes
 * Date: 4/4/2017
 * Time: 7:50 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class OrganizationRoleUser extends Model
{
    protected $table = 'organization_user';

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function organization() {
        return $this->belongsTo('App\Organization');
    }

    public function role(){
        return $this->belongsTo('App\Role');
    }
}