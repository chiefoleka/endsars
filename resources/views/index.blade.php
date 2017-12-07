@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="app">
        <div class="col-md-8 col-md-offset-2">
			<h3 class="text-center hero-text">Stories of people who have had a bad encounter with SARS</h3>
        	<ul class="nav nav-tabs">
			  	<li class="active"><a data-toggle="tab" href="#stories">Stories</a></li>
				<li><a data-toggle="tab" href="#tweets">Twitter Stories</a></li>
				<li><a data-toggle="tab" href="#feeds">Live Feed</a></li>
			</ul>
				
			<div class="tab-content">
				<div id="stories" class="tab-pane fade in active" style="margin-top: 40px">
		        	<stories></stories>
			    </div>
				<div id="feeds" class="tab-pane fade">
					<feeds></feeds>
				</div>
				<div id="tweets" class="tab-pane fade">
					<tweets></tweets>
				</div>
		    </div>
        </div>
    </div>
</div>
@endsection
