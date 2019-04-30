@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Users</div><!-- START Language list-->
					 <div class="ml-auto">
							<button class="btn btn-labeled btn-success" type="button"><a href="{{ route('superadmin.company.addNewUser') }}" class="btn-label whitetext"><i class="fa fa-plus"></i></a>Add New User</button>
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
														 <th style="text-align:right;">Status</th>
														 <th>Links</th>
														 <th class="sort-numeric">Sections</th>
														 <th>Company</th>
														 <th>User Type</th>
														 <th>Actions</th>
														 <th>Last Login</th>
														 <th>Notes</th>
													</tr>
											 </thead>
											 <tbody>
												 @foreach($users as $user)
														 <tr id="hide_{{ $user->id }}">
															  <td><a style="display:none;" href="{{ route('superadmin.users.user', ['user'=>$user->id],'?tab=profile') }}">{{ $user->name }}</a>
																 <a href="{{ route('superadmin.usersetting.user', ['user'=>base64_encode($user->id)]) }}?tab=profile">{{ $user->name }}</a></td>
																 <th><center><i class="fa fa-circle success-circle"></i></center></th>
																 <td>{{ $user->links->count() }}</td>
																 <td><a href="{{ route('superadmin.usersetting.user', ['user'=>base64_encode($user->id)]) }}?tab=shield">{{ @$user->sections->count() }}</a></td>
																 <td>{{ $user->companyname->company_name }}</td>
																 <td>{{ @$user->levelname->level_name }}</td>
																 <td>
																	 <form action="{{ route('superadmin.users.status', ['user' => $user->id]) }}" method="POST">
																					 {{ csrf_field() }}
																						 <a type="submit" title="Edit User" href = "{{ route('superadmin.usersetting.user', ['user'=>base64_encode($user->id)]) }}?tab=profile" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
																						 <button type="submit" title="Play Campaign" class="btn btn-secondary btn-xs"><i class="fa fa-play"></i></button>
																						 <button type="submit" title="eye Campaign" class="btn btn-secondary btn-xs"><i class="fa fa-eye"></i></button>
																						 <button type="button" class="btn btn-danger btn-xs confirmDelete" data-siteurl ="{{ url('/')}}" data-tablename="users" data-record-id="{{ $user->id }}" data-record-title="Are you sure you want to delete this User ?" data-toggle="modal" data-target="modal-confirm" data-succuss="User deleted successfully" data-deletetype="softdelete">
			                                          <i class="fa fa-trash"></i></button>
																							</form>
																 </td>
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
