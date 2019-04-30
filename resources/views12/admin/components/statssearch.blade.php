<div class="col-lg-12 col-md-12 statuses">
	@if(session('status'))
		<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong> Success! </strong> {{ session('status') }}
		</div>
	@endif
	@if(session('error'))
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong> Warning! </strong> {{ session('error') }}
		</div>
	@endif
</div>
