@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 class="text-center">{{$incident->user->name}}</h2>
            <div class="row">
            	<span class="col-md-4"><i class="fa fa-map-marker"> {{$incident->location->name}}</i></span>
            	<span class="col-md-4 pull-right"><i class="fa fa-clock-o"> {{$incident->when->format('F')}}, {{$incident->when->year}}</i></span>
            </div>
            <hr>
            <div class="incident">
            	{!! $incident->incident !!}
            </div>
            @if(!empty($incident->actions))
            <div>
            	<h4><strong>What happened to the person:</strong></h4>
            	<ul class="ul-left-shift">
            		@foreach($incident->actions as $action)
					<li>{{$action->name}}</li>
            		@endforeach
            	</ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
