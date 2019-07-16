<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * An aggregate is a named collection of Organizations belonging to an Organization.
 * */

class Aggregate extends Model
{
    protected $fillable = [
        'name'
    ];

    /*
     * The organization that owns this Aggregate.
     * */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    /*
     * The organizations in this aggregate.
     * */
    public function organizations()
    {
        return $this->belongsToMany('App\Organization')->visible();
    }
}
