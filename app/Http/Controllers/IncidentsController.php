<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\User;
use App\Action;
use App\Location;
use App\Incidents;
use Auth;
use Validator;
use Abraham\TwitterOAuth\TwitterOAuth;

class IncidentsController extends Controller
{
    public function index(Request $request)
    {	
    	if(isset($request->page)) {
    		$noPage = false;
    	}
    	else {
    		$noPage = true;
    	}
    	$incidents = Incidents::orderBy('created_at', 'desc')->paginate(20);
    	foreach ($incidents as $incident) {
    		$incident->summary 	= self::summary($incident->incident,$incident->id);
    		$incident->when 	= \Carbon\Carbon::parse($incident->when);
    	}
        return view('index', [
        	'incidents' => $incidents,
        	'noPage'	=> $noPage
        ]);
    }

    public function tweets(){
    	$access_token = "";
    	$access_token_secret = "";

    	$connection = new TwitterOAuth(env('TWITTER_CKEY'), env('TWITTER_CSECRET'), $access_token, $access_token_secret);

    	$tweets = $connection->get("search/tweets", ["q" => "%23EndSARS", "count" => 30, "exclude_replies" => true]);
    	
    	foreach ($tweets->statuses as $tweet) {
    		$tweet->date = \Carbon\Carbon::parse($tweet->created_at);
    	}

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
            'email' 	=> 'required|string|email|max:255|unique:users',
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
	        $user->phone 	= $request->phone;
	        $user->twitter 	= $request->twitter;
	        $user->password = bcrypt($request->password);
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
