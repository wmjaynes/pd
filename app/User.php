<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
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

    public function scopeSuperuser($query)
    {
        $query->where('superuser', 1);
    }

    public function nameOrEmail()
    {
        if (empty(trim($this->name)))
            return $this->email;
        else
            return $this->name;
    }


    public function hasOrganization($name)
    {
        foreach ($this->organizations as $org) {
            if ($org->name == $name) return true;
        }

        return false;
    }

    public function addApprovedOrganization($organization) {
        $this->organizations()->save($organization, ['approved' => true]);
    }

    public function addOrganization($organization) {
        $this->organizations()->save($organization, ['approved' => false]);
    }

    public function organizations()
    {
        return $this->belongsToMany('App\Organization')
            ->withPivot('approved', 'created_at');
    }

    public function getApprovedOrganizations()
    {
        return $this->belongsToMany('App\Organization')
            ->withPivot('approved', 'created_at')
            ->wherePivot('approved', 1);;
    }

    public function getUnapprovedOrganizations()
    {
        return $this->belongsToMany('App\Organization')
            ->withPivot('approved', 'created_at')
            ->wherePivot('approved', 0);;
    }

    public function currentOrganization()
    {
        return $this->belongsTo('App\Organization', 'activeOrganization');
    }

    /**
     * This does too much. Should refactor.
     *
     * @param Organization $organization
     * @return bool
     */
    public function setCurrentOrganization(Organization $organization)
    {
        if (!isset($this->currentOrganization)) {
            $this->currentOrganization()->associate($this->organizations()->first());
            $this->save();
        }
        if ($this->superuser || $this->hasOrganization($organization->name)) {
            $this->currentOrganization()->associate($organization);
            $this->save();
            return true;
        }
        return false;
    }


}
