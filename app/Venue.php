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
        'postalCode'
    ];

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function fullAddress()
    {
        $streetAddress = $this->streetAddress;
        return "$this->streetAddress, $this->addressLocality $this->addressRegion $this->postalCode";
    }
}
