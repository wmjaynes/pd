<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'streetAddress',
        'addressLocality',
        'addressRegion',
        'addressCountry',
        'postalCode',
        'visible',
    ];

    public function scopeVisible($query)
    {
        $query->where('visible', '=', 1)->orderBy('name', 'asc');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function nameCity()
    {
        return "$this->name, $this->addressLocality, $this->addressRegion";
    }

    public function fullAddress()
    {
        $streetAddress = $this->streetAddress;
        return "$this->streetAddress, $this->addressLocality $this->addressRegion $this->postalCode";
    }
}
