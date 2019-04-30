@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Shields Assigned to Company</div><!-- START Language list-->
					 <div class="ml-auto">
					  </div><!-- END Language list-->
				</div>
				<div class="row">
					 <div class="col-lg-12">
							<div class="panel panel-default">
								 <div class="panel-body">
									 <div class="table-responsive">
									 <table class="table table-striped my-4 w-100" id="datatable2">
											<thead>
												 <tr>
														<th>Shield Name</th>
														<th>Creation Date</th>
														<th>Notes</th>
												 </tr>
											</thead>
											<tbody>
												@foreach($assignedSection as $section)
													<tr>
																<td>{{ $section->name }}</td>
																<td>{{$section->created_at->format(config('app.dateformat'))}}</td>
																<td><p title="{{ @$section->notes}}">{{ str_limit(@$section->notes, 10,'....') }}</p></td>
													</tr>
													@endforeach
											</tbody>
									 </table>
									 </div>
								 </div>
							</div>
					 </div>
				</div>
		 </div>
	</section>
@endsection

@section('scripts')
    <script>
    $(document).ready(function() {
        $('.datatable1').DataTable({
            responsive: true
        });
    });
    </script>
@endsection
