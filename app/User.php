<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $currentOrganization;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'userId',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token',
    ];

    public function nameOrEmail()
    {
        if (empty(trim($this->name)))
            return $this->email;
        else
            return $this->name;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) return true;
        }

        return false;
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    public function hasOrganization($name)
    {
        foreach ($this->organizations as $org) {
            if ($org->name == $name) return true;
        }

        return false;
    }

    public function organizations()
    {
        return $this->belongsToMany('App\Organization')->withTimestamps()->withPivot('role_id')->using(OrganizationRoleUser::class);
    }

    public function currentOrganization()
    {
        return $this->belongsTo('App\Organization', 'activeOrganization');
    }

    public function setCurrentOrganization(Organization $organization)
    {
        if ($this->hasOrganization($organization->name)) {
            $this->currentOrganization()->associate($organization);
            $this->save();
            return true;
        }
        return false;
    }

    public function organization()
    {
        return $this->organizations()->first();
    }


}
