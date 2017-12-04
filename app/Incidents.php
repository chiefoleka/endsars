<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Incidents extends Model
{
    public $table = 'incidents';

    public $guarded = [];

    public $incrementing = false;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function location(){
    	return $this->belongsTo('App\Location');
    }

    public function actions(){
    	return $this->belongsToMany('App\Action', 'incident_action', 'incident_id', 'action_id');
    }
}
