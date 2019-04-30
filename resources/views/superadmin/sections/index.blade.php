@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Shields</div><!-- START Language list-->
					 <div class="ml-auto">
							<button class="btn btn-labeled btn-success" type="button"><a href="{{ route('superadmin.sections.new') }}" class="btn-label whitetext"><i class="fa fa-plus"></i></a>Add New Shield</button>
					 </div><!-- END Language list-->
				</div>
				@include('admin.components.statuses')
				<div class="row">
					 <div class="col-lg-12">
							<div class="panel panel-default">
								 <div class="panel-body">
									 <div class="table-responsive">
									 <table class="table table-striped my-4 w-100" id="datatable2">
											<thead>
												 <tr>
														<th>Shield Name</th>
														<th>Links</th>
														<th>Users</th>
														<th>Creator</th>
														<th>Actions</th>
														<th>Creation Date</th>
														<th>Notes</th>
												 </tr>
											</thead>
											<tbody>
												@foreach($sections as $section)
														<tr>
																	<td><a href="{{ route('superadmin.sections.section', ['section'=> $section->slug]) }}">{{ $section->name }}</a></td>
																	<td>@if(!empty($section->links)){{ $section->links->count() }}@else 0 @endif</td>
																	<td>@if(!empty($section->assignedto)){{ $section->assignedto->count() }}@else 0 @endif</td>
																	<td>{{$section->createdby->name}}</td>
																	<td>
																			<a href="{{ route('superadmin.sections.section', ['section'=> $section->slug]) }}" class="btn btn-xs btn-success"><i class="fa fa-edit">&nbsp;</i></a>
																			<a href="{{ route('superadmin.sections.section', ['section'=> $section->slug]) }}" class="btn btn-xs btn-primary"><i class="fa fa-link">&nbsp;</i></a>
																			<form action="{{ route('superadmin.sections.delete', ['section' => $section->slug]) }}" style="display: inline-block;" method="POST">
																					{{ csrf_field() }}
																					<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash">&nbsp;</i></button>
																			</form>
																	</td>
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
