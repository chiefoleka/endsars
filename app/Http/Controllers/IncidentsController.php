<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\User;
use App\Action;
use App\Location;
use App\Incidents;
use App\Tweets;
use Auth;
use Validator;
use Abraham\TwitterOAuth\TwitterOAuth;

class IncidentsController extends Controller
{
    public function index(Request $request)
    {	
    	return view('index');
    }

    public function stories(Request $request)
    {   
        $incidents = Incidents::orderBy('created_at', 'desc')->paginate(30);
        foreach ($incidents as $incident) {
            $incident->summary  = self::summary($incident->incident,$incident->id);
            $incident->when     = \Carbon\Carbon::parse($incident->when);
            $incident->year     = $incident->when->year;
            $incident->location = $incident->location->name;
            $incident->name     = $incident->user->name;
        }
        return response()->json(array(
            'success' => true,
            'data'   => $incidents
        ));
    }

    public function oldTweets() {
        $tweets = Tweets::orderBy('id', 'desc')->paginate(30);
        foreach ($tweets as $tweet) {
            $tweet->id_str  = "'".$tweet->id."'";
            $tweet->tweet   = htmlspecialchars_decode($this->_return_url($tweet->tweet));
            $tweet->tweet   = htmlspecialchars_decode($this->_replace_handle($tweet->tweet));
        }
        return response()->json(array(
            'success'   => true,
            'data'      => $tweets,
            'actions'   => Action::all()
        ));
    }

    private function _return_url($text){
        $pattern  = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
        $callback = create_function('$matches', '
           $url       = array_shift($matches);
           $url_parts = parse_url($url);

           $text = parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH);
           $text = preg_replace("/^www./", "", $text);

           return sprintf(\'<a rel="nowfollow" target="_blank" href="%s">%s</a>\', $url, $text);
        ');

       return preg_replace_callback($pattern, $callback, $text);
    }

    private function _replace_handle($text){
        $pattern  = '#(?<=^|(?<=[^a-zA-Z0-9-_\.]))@([A-Za-z]+[A-Za-z0-9]+)#';
        $callback = create_function('$matches', '
           $handle  = array_shift($matches);
           return sprintf(\'<a rel="nowfollow" target="_blank" href="https://twitter.com/%s">%s</a>\', trim($handle,"@"), $handle);
        ');

       return preg_replace_callback($pattern, $callback, $text);
    }

    public function deleteTweet(Request $request) {
        $tweet = Tweets::find($request->id);
        $tweet->delete();
        return response()->json(array(
            'success' => true,
            'data'   => "Deleted"
        ));
    }

    public function addActions(Request $request) {
        $tweet = Tweets::find($request->id);
        if($tweet->actions()->syncWithoutDetaching($request->actions))
        {
            return response()->json(array(
                'success' => true,
                'message'   => "Actions synced"
            ));
        }
    }

    public function tweets(){
    	$access_token = "";
    	$access_token_secret = "";

    	$connection = new TwitterOAuth(env('TWITTER_CKEY'), env('TWITTER_CSECRET'), $access_token, $access_token_secret);

    	$tweets = $connection->get("search/tweets", ["q" => "%23EndSARS -filter:retweets", "count" => 30, "exclude_replies" => true]);

    	return response()->json(array(
            'success' => true,
            'data'   => $tweets->statuses
        ));
    }

    public function single(Incidents $id)
    {
    	$id->when = \Carbon\Carbon::parse($id->when);
        return view('single', [
        	'incident' => $id
        ]);
    }

    public function create() {
    	return view('create', [
    		'actions' 	=> Action::all(),
    		'locations' => Location::all()
    	]);
    }

    public function createhidden() {
        return view('createback', [
            'actions'   => Action::all(),
            'locations' => Location::all()
        ]);
    }

    public function store(Request $request) {
    	$user_id = '';
    	$guest = [
    		'name' 		=> 'required|string|max:255',
            'email' 	=> 'nullable|string|email|max:255|unique:users',
            'phone' 	=> 'nullable|string|max:11',
            'twitter' 	=> 'nullable|string|max:15',
            'password' 	=> 'nullable|string|min:6|confirmed'
        ];

        $validator = [
            'incident'	=> 'required',
            'actions'	=> 'nullable|array',
            'location'	=> 'required|integer',
            'month'		=> 'required|digits:2',
            'year'		=> 'required|integer'
        ];
    	if(!Auth::check()){
    		Validator::make($request->all(), $guest)->validate();
    		$user 			= new User;
	        $user->name 	= $request->name;
	        $user->email 	= $request->email;
	        // $user->twitter 	= $request->twitter;
	        // $user->password = bcrypt($request->password);
            $user->phone    = $request->phone;
	        if($user->save()){
	        	$user_id = $user->id;
	        	if(!empty($request->password)){
	        		Auth::attempt(['email' => $request->email, 'password' => $request->password]);
	        	}
	        }
	        else {
	        	dd("user failed");
	        	\Session::flash('error', 'Your personal data could not be saved.');
        		return back();
	        }
    	}
    	else {
    		$user_id = Auth::id();
    	}

    	Validator::make($request->all(), $validator)->validate();
    	
        
    	$incident = Incidents::create([
    		'id'			=> Uuid::generate()->string,
    		'incident' 		=> $request->incident,
    		'user_id' 		=> $user_id,
    		'location_id'	=> $request->location,
    		'when'			=> \Carbon\Carbon::create($request->year, $request->month, '01')
    	]);
    	$incident->actions()->syncWithoutDetaching($request->actions);

    	\Session::flash('success', 'Your incident has been recorded');
        return back();
        
    }

    public function createback(Request $request) {
        if(!Auth::check()){
            abort('403', 'Unauthorized');
        }
        $validator = [
            'incident'  => 'required',
            'actions'   => 'nullable|array',
            'location'  => 'required|integer',
            'month'     => 'required|digits:2',
            'year'      => 'required|integer',
            'name'      => 'required|string|max:255',
            'twitter'   => 'nullable|string|max:15'
        ];
        Validator::make($request->all(), $validator)->validate();
        $user           = User::firstOrCreate(['twitter' => $request->twitter], ['name' => $request->name]);
        
        $incident = Incidents::create([
            'id'            => Uuid::generate()->string,
            'incident'      => $request->incident,
            'user_id'       => $user->id,
            'location_id'   => $request->location,
            'when'          => \Carbon\Carbon::create($request->year, $request->month, '01')
        ]);
        $incident->actions()->syncWithoutDetaching($request->actions);

        \Session::flash('success', 'Your incident has been recorded');
        return back();
        
    }

    public static function summary($string, $url) {
      $string = strip_tags($string);

      if (strlen($string) > 450) {
          // truncate string
          $stringCut = substr($string, 0, 450);
          // make sure it ends in a word so assassinate doesn't become ass...
          $string = substr($stringCut, 0, strrpos($stringCut, ' '))." . . . "."<a href=".url('/incidents')."/".$url.">Read More</a>"; 
      }
      return htmlspecialchars_decode($string);
    }
}
