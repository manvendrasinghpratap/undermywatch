@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
			 <div class="content-wrapper">
				 <div class="content-heading">
						<div> @if(isset($pageHeading)) {{ $pageHeading }}  @else Dashboard @endif<small data-localize="dashboard.welcome"></small></div><!-- START Language list-->
						<div class="ml-auto">
							 <div class="btn-group"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
									<div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a></div>
							 </div>
						</div><!-- END Language list-->
				 </div>
				 <div class="row">
						<div class="col-12 text-center">
							 <h2 class="text-thin">Single view content</h2>
							 <p>This project is an application skeleton. You can use it to quickly bootstrap your webapp projects and dev environment for these projects.<br>The seed app doesn't do much and has most of the feature removed so you can add theme as per your needs just following the demo app examples.</p>
						</div>
				 </div>
			 </div>
		 </section>

@endsection

@section('scripts')
@endsection
