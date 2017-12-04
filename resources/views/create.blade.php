@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-bottom: 100px">
        	@if (Session::has('success'))
			   <div class="alert alert-success center alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ Session::get('success') }}</div>
			@endif
			@if ($errors->any())
				@foreach($errors as $error)
			   	<p>{{$error}}</p>
			   	@endforeach
			@endif
		    <form class="form" action="{{route('share')}}" method="POST">
		    	{{csrf_field()}}
        		<div class="tab-content">
        			<div id="incident" class="tab-pane fade in active">
        				<h3 class="text-center">Share your experience at the hands of SARS</h3>
        				<hr>
		            	<div class="form-group {{ $errors->has('incident') ? ' has-error' : '' }}">
		            		<label for="incident">What happened?</label>
		            		<textarea class="form-control" style="resize: none" rows="10" name="incident" placeholder="Please be as expressive as possible" required>{{old('incident')}}</textarea>
		            		@if ($errors->has('incident'))
                                <span class="help-block">
                                    <strong>Please fill in the incident</strong>
                                </span>
                            @endif
		            	</div>
		            	<div class="form-group">
		            		<div class="row">
		            			<div class="col-md-6 {{ $errors->has('location') ? ' has-error' : '' }}">
		            				<label for="location">Where did it happen?</label>
		            				<select name="location" class="form-control" required>
		            					@foreach($locations as $location)
		            					<option value="{{$location->id}}">{{$location->name}}</option>
		            					@endforeach
		            				</select>
		            				@if ($errors->has('location'))
		                                <span class="help-block">
		                                    <strong>{{$errors->first('location')}}</strong>
		                                </span>
		                            @endif
		            			</div>
		            			<div class="col-md-6">
		            				<label for="date">When did it happen?</label>
		            				<div class="row">
			            				<span class="col-md-6 {{ $errors->has('month') ? ' has-error' : '' }}">
			            					<select name="month" class="form-control" required>
				            					@foreach(config('dateinfo.month') as $key => $value)
				            					<option value="{{$key}}">{{$value}}</option>
				            					@endforeach
				            				</select>
				            				@if ($errors->has('month'))
				                                <span class="help-block">
				                                    <strong>{{$errors->first('month')}}</strong>
				                                </span>
				                            @endif
			            				</span>
			            				<span class="col-md-6 {{ $errors->has('year') ? ' has-error' : '' }}">
			            					<select name="year" class="form-control" required>
				            					@foreach(config('dateinfo.year') as $key => $value)
				            					<option value="{{$value}}">{{$value}}</option>
				            					@endforeach
				            				</select>
				            				@if ($errors->has('year'))
				                                <span class="help-block">
				                                    <strong>{{$errors->first('year')}}</strong>
				                                </span>
				                            @endif
			            				</span>
		            				</div>
		            			</div>
		            		</div>
		            	</div>
		            	<div class="form-group">
		            		<br>
		            		<label for="incident">What did they do to you/the person?</label>
		            		<br><hr>
		            		<div class="row {{ $errors->has('actions') ? ' has-error' : '' }}">
		            			@foreach($actions as $action)
	            				<span class="col-md-4" style="margin-bottom: 10px">
	            					<input type="checkbox" name="actions[]" value="{{$action->id}}"> {{$action->name}}
	            				</span>
	            				@endforeach
	            				<span class="col-md-12">
	            					@if ($errors->has('actions'))
		                                <span class="help-block">
		                                    <strong>{{$errors->first('actions')}}</strong>
		                                </span>
		                            @endif
	            				</span>
            				</div>
		            	</div>
		            	<hr>
		            	@if(Auth::check())
						<div class="form-group">
		            		<input type="submit" id="submit" value="Share" class="btn btn-primary btn-lg pull-right">
		            	</div>
		            	@else
		            	<div class="form-group">
		            		<a data-toggle="tab" href="#personal"><button class="btn btn-primary btn-lg pull-right">Continue</button></a>
		            	</div>
		            	@endif
			        </div>
			        @if(!Auth::check())
			        <div id="personal" class="tab-pane fade">
			        	<h3 class="text-center">Please fill out your details below</h3>
			        	<hr>
			        	<p style="color:red">* required</p>
						<div class="form-group">
							<label for=name>What is your name? *</label>
							<input type="text" name="name" class="form-control" placeholder="fullname" required>
						</div>
						<div class="form-group">
							<label for=name>Your email address? *</label>
							<input type="email" name="email" class="form-control" placeholder="email" required>
						</div>
						<div class="form-group">
							<div class="row">
			            		<span class="col-md-6">
									<label for=name>Phone Number</label>
									<input type="text" name="phone" class="form-control" placeholder="phone number" required>
								</span>
			            		<span class="col-md-6">
									<label for=name>Twitter handle</label>
									<input type="text" name="twitter" class="form-control" placeholder="twitter" required>
								</span>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<p>If you would like to track activities around your report, then provide a password to create an account right away.</p>
							<div class="row">
			            		<span class="col-md-6">
									<label for=name>Password</label>
									<input type="password" name="password" class="form-control" placeholder="" required>
								</span>
								<span class="col-md-6">
									<label for=name>Confirm Password</label>
									<input type="password" name="password_confirmation" class="form-control" placeholder="" required>
								</span>
							</div>
						</div>
						<hr>
			        	<div class="form-group">
			        		<a data-toggle="tab" href="#incident"><button class="btn btn-default btn-lg">Back</button></a>
		            		<input type="submit" id="submit" name="Share" class="btn btn-success btn-lg pull-right">
		            	</div>
			        </div>
			        @endif
	        	</div>
		    </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/tinymce/tinymce.min.js')}}"></script>
<script>
	tinymce.init({ 
		selector:'textarea',
		menubar:false,
    	statusbar: false,
		branding: false 
	});

	var submit 		= document.getElementById('submit')

	submit.addEventListener('click', function(e){
		tinyMCE.triggerSave()
		document.querySelector('.form').submit()

	})

</script>
@endsection
