@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="app">
        <div class="col-md-8 col-md-offset-2">
			<h3 class="text-center hero-text">Stories of people who have had a bad encounter with SARS</h3>
        	<ul class="nav nav-tabs">
			  	<li class="active"><a data-toggle="tab" href="#stories">Stories</a></li>
				<!-- <li><a data-toggle="tab" href="#tweets">Twitter Stories</a></li> -->
				<li><a data-toggle="tab" href="#feeds">Twitter Stories</a></li>
			</ul>
				
			<div class="tab-content">
				<div id="stories" class="tab-pane fade in active" style="margin-top: 40px">
		        	<p style="font-size: 18px; line-height: 1.5">This survey seeks to document citizens' experience(s) with the Special Anti-Robbery Squad (SARS) of the Nigeria Police Force for the sole purpose of supporting the advocacy for better policing in Nigeria.</p>
		        	<p style="font-size: 18px; line-height: 1.5">By completing this survey, you will be contributing to making Nigeria a better place. KINDLY SHARE ONLY PERSONAL EXPERIENCES.</p>
		        	<br>
		        	<div style="display:table; margin: 0 auto;">
		        		<a href="https://s.surveyplanet.com/r1aUDNy-7" target="_blank" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i> Share Your Experience</a>
		        	</div>
			    </div>
				<div id="feeds" class="tab-pane fade">
					<feeds></feeds>
				</div>
				<!-- <div id="tweets" class="tab-pane fade">
					<tweets></tweets>
				</div> -->
		    </div>
        </div>
    </div>
</div>
@endsection
