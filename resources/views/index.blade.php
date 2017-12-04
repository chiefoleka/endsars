@extends('layouts.app')

@section('content')
<style type="text/css">
	.h300 {
		height: 300px !important;
	}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			<h3 class="text-center hero-text">Stories of people who have had a bad encounter with SARS</h3>
        	<ul class="nav nav-tabs">
        		@if($noPage)
			  	<li class="active"><a data-toggle="tab" href="#tweets">Tweets</a></li>
			  	<li><a data-toggle="tab" href="#stories">Stories</a></li>
			  	@else
				<li><a data-toggle="tab" href="#tweets">Tweets</a></li>
			  	<li class="active"><a data-toggle="tab" href="#stories">Stories</a></li>
			  	@endif
			</ul>
				
			<div class="tab-content">
				@if($noPage)
				<div id="tweets" class="tab-pane fade in active">
				@else
				<div id="tweets" class="tab-pane fade">
				@endif
					<div class="flex-center" style="margin-top: 40px">
						<i class="fa fa-spinner fa-5x fa-spin"></i>
						<p class="text-center">Loading tweets ... </p>
					</div>
				</div>
				@if($noPage)
				<div id="stories" class="tab-pane fade">
				@else
				<div id="stories" class="tab-pane fade in active">
				@endif
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
    </div>
</div>
@endsection
@section('scripts')
	<script type="text/javascript">
		function getTweetBox(handle,name,tweet,retweets){
			var div = document.createElement('div')
            div.classList.add('col-md-4','tweet')
            var data = '<a href="https://twitter.com/'+handle+'"><h4>'+name+'</h4></a>'+
						'<div class="row summary">'+tweet+'</div>'+
						'<span><i class="fa fa-retweet"></i>'+retweets+' &nbsp;</span>'
            div.innerHTML = data
			return div
		}
		var tweetBox = document.getElementById('tweets')

		window.onload = function(){
			$.ajax({
				url : '{{url("/getTweets")}}',
				success: function(response){
					tweetBox.innerHTML = ""
					response.data.forEach(function(data){
						var handle = data.user['screen_name']
						var name = data.user['name']
						var tweet = data.text
						var retweets = data['retweet_count']
						tweetBox.appendChild(getTweetBox(handle,name,tweet,retweets))
					})
				}
			});
		}
	</script>
@endsection
