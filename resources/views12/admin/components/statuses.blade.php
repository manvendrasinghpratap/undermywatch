<div class="col-lg-12 col-md-12 statuses" id="successMessage">
	@if(Session::get('status'))
		<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong> Success! </strong> {{ session('status') }}
		</div>
	@endif
	@if(Session::get('error'))
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong> Warning! </strong> {{ session('error') }}
		</div>
	@endif
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function() {
	    $('#successMessage').fadeOut('slow');
	}, 1500)
});
; // <-- time in milliseconds
</script>
<?php
Session::forget('status');
Session::forget('error');
