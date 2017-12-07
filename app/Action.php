<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    public $table = 'actions';

    public $guarded = [];

    public $timestamps = false;

    public function tweets(){
    	return $this->belongsToMany('App\Action', 'tweets_actions', 'action_id', 'tweet_id');
    }

    public function actions(){
    	return $this->belongsToMany('App\Action', 'incident_action', 'action_id', 'incident_id');
    }
}
