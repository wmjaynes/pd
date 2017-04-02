<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'startDate',
        'endDate',
        'timeInfo',
        'published',
        'description',
        'allDay',
        'timeInfo',
        'contactName',
        'phone',
        'email',
        'url',
        'ticketInfo',
        'free',
        'imageUrl',
        'flyerUrl',
        'ticketUrl',
        'altMapUrl',
        'venueDetail',
        'tags'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'startDate',
        'endDate'
    ];

    public function venue()
    {
        return $this->belongsTo('App\Venue');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}
