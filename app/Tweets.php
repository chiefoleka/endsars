<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweets extends Model
{
    public $table = 'tweets';

    public $guarded = [];

    public function actions(){
    	return $this->belongsToMany('App\Action', 'tweets_actions', 'tweet_id', 'action_id');
    }
}
