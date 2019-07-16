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
        'approved',
    ];

    public function scopeVisible($query)
    {
        $query->where('approved', '=', 1)->orderBy('name', 'asc');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function user()
    {
        return $this->users()->first();
    }

//    public function aggregates()
//    {
//        return $this->belongsToMany('App\Aggregate');
//    }

    public function aggregates()
    {
        return $this->hasMany('App\Aggregate');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function venues() {
        return $this->hasManyThrough('App\Venue', 'App\Event');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

}
