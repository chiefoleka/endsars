<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use App\Tweets;

class TweetsController extends Controller
{
    public function tweetsSince($id = null){
        $access_token = "";
        $access_token_secret = "";

        $connection = new TwitterOAuth(env('TWITTER_CKEY'), env('TWITTER_CSECRET'), $access_token, $access_token_secret);

        for($i=0;$i<10000;$i++){
        $tweets = $connection->get("search/tweets", ["q" => "%23EndSARS OR %23PoliceReformNG -filter:retweets", 'count' =>50,  "since" => "2017-12-02", "until" => "2017-12-07", "exclude_replies" => false, "tweet_mode" => "extended", "max_id" => $id, "result_type" => "recent"]);
        	if(empty($tweets->statuses)) {
        		break;
        	}
	        foreach ($tweets->statuses as $tweet) {
	        	Tweets::firstOrCreate(['id' => $tweet->id],[
	        		'handle' 	=> $tweet->user->screen_name,
	        		'name'		=> $tweet->user->name,
	        		'tweet'		=> $tweet->full_text,
	        		'retweets'	=> $tweet->retweet_count
	        	]);
	        	$id 			= $tweet->id;
	        }
	    }
        return response()->json(array(
            'success' 			=> true,
            'data'   			=> "Tweets added"
        ));
    }
}
