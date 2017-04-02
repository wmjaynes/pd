<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
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
}
