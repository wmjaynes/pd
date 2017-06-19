<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'address1',
        'address2',
        'state',
        'city',
        'postalCode',
        'email',
        'phone',
        'contactName',
        'url',
        'logoUrl',
        'facebookUrl',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps()->withPivot('role_id')->using(OrganizationRoleUser::class);
    }

    public function user()
    {
        return $this->users()->first();
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function aggregators()
    {
        return $this->belongsToMany('App\Organization', 'aggregates', 'aggregatee_id', 'aggregator_id');
    }

    public function aggregatees()
    {
        return $this->belongsToMany('App\Organization', 'aggregates', 'aggregator_id', 'aggregatee_id');
    }

    public function aggregateesNotMe() {
        return $this->aggregatees->except(['id' => $this->id]);
    }
}
