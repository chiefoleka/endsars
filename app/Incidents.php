<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidents extends Model
{
    public $table = 'incidents';

    public $guarded = [];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function actions(){
    	return $this->belongsToMany('App\Action', 'incident_action', 'incident_id', 'action_id');
    }
}
