<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function organizationRoleUsers() {
        return $this->hasMany('App\OrganizationRoleUser');
    }
}
