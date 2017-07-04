<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $xstartDate, $xendDate, $startTime, $endTime;

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

    public function scopePublished($query)
    {
        $query->where('published', '=', 1);
    }

    public function scopeUnpublished($query)
    {
        $query->where('published', '=', 0);
    }

    public function scopeFuture($query)
    {
        $query->where('startDate', '>=', Carbon::now());
    }

    public function venue()
    {
        return $this->belongsTo('App\Venue');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
