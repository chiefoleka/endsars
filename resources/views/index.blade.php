@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
	    	<h3 class="text-center hero-text">Stories of people who have had a bad encounter with SARS</h3>
        @foreach($incidents as $incident)
	    	<div class="col-md-12 incident-header">
	            <a href="{{url('incidents')}}/{{$incident->id}}">
	            	<h4>{{$incident->user->name}}'s Incident <small class="pull-right"><i class="fa fa-map-marker"> {{$incident->location->name}}</i> &nbsp; <i class="fa fa-clock-o"> {{$incident->when->year}}</i></small></h4>
	            </a>
	            <div class="row summary">
	            	{!! $incident->summary !!}
	            </div>
	        </div>
        @endforeach
	        <div class="flex-center">
	        	{{ $incidents->links() }}
	        </div>
        </div>
    </div>
</div>
@endsection
