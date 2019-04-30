@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Users</div><!-- START Language list-->
					 <div class="ml-auto">
							<button class="btn btn-labeled btn-success" type="button"><a href="{{ route('admin.users.create') }}" class="btn-label whitetext"><i class="fa fa-plus"></i></a>Add New User</button>
					 </div><!-- END Language list-->
				</div>
				<div class="row">
					 <div class="col-lg-12">
							<div class="panel panel-default">
								 <div class="panel-body">
										<div class="table-responsive">
											<table width="100%" class="table table-striped table-bordered table-hover datatable1">
											 <thead>
													<tr>
														<th>Name</th>
														 <th>Email</th>
														 <th style="text-align:right;">Status</th>
														 <th>Links</th>
														 <th class="sort-numeric">Sections</th>
														 <th>User Type</th>
														 <th>Actions</th>
														 <th>Created Date</th>
														 <th>Last Login</th>
														 <th>Notes</th>
													</tr>
											 </thead>
											 <tbody>
												 @foreach($users as $user)
														 <tr>
														 <td>
															<a href="{{ route('admin.usersetting.user', ['user'=>base64_encode($user->id)]) }}?tab=profile">{{ $user->name }}</a>
														</td>
														 <td>{{ $user->email }}</td>
														 <th><center><i class="fa fa-circle success-circle"></i></center></th>
														 <td>{{ $user->links->count() }}</td>
														 <td>{{ @$user->sections->count() }}</td>
														 <td>{{ @$user->levelname->level_name }}</td>
																 <td>
																	 <form action="{{ route('admin.users.destroy', ['user' => base64_encode($user->id)]) }}" method="POST">
																						{{ csrf_field() }}
																						<a type="submit" title="Edit User" href = "{{ route('admin.usersetting.user', ['user'=>base64_encode($user->id)]) }}?tab=profile" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
																		 <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
																		</form>
																 </td>
																 <td>{{ $user->created_at }}</td>
																 <td>{{ $user->last_login_at}}</td>
																 <td><p title="{{ $user->notes}}">{{ str_limit($user->notes, 10,'...') }}</p></td>
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
				$.ajaxSetup({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
						}
				});
    });

    </script>
@endsection
