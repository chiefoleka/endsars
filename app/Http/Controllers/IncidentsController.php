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

class IncidentsController extends Controller
{
    public function index()
    {	$incidents = Incidents::paginate(20);
    	foreach ($incidents as $incident) {
    		$incident->summary 	= self::summary($incident->incident,$incident->id);
    		$incident->when 	= \Carbon\Carbon::parse($incident->when);
    	}
        return view('index', [
        	'incidents' => $incidents
        ]);
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
