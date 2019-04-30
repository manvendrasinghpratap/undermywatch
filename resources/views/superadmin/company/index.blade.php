@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Company</div><!-- START Language list-->
					 <div class="ml-auto">
							<button class="btn btn-labeled btn-success" type="button"><a href="{{ route('superadmin.company.create') }}" class="btn-label whitetext"><i class="fa fa-plus"></i></a>Add New Company</button>
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
																<th>Company Name</th>
																<th>Contact Person</th>
																<th>Email</th>
																<th>Contact No.</th>
																<th>Sections</th>
																<th>Users</th>
	                              <th>Action </th>
	                            </tr>
	                        </thead>
													<tbody>
	                        	@foreach($companyData as $company)
		                            <tr>
																			<td>{{ $company->company_name }}</td>
																			<td>{{ $company->contact_person }}</td>
																			<td>{{ $company->company_email }}</td>
																			<td>{{ $company->contact_no }}</td>
																			<td><a href="{{ route('superadmin.company.edit', ['company' => base64_encode($company->id)]) }}?tab=shield">{{ $company->sections->count() }}</a></td>
																			<td><a href="{{ route('superadmin.company.edit', ['company' => base64_encode($company->id)]) }}?tab=shield">{{ $company->users->count() }}</a></td>
																			<td>
		                                        @if(Auth::user()->level == config('app.superadminlevel') )
																							<form action="{{ route('superadmin.company.edit', ['company' => base64_encode($company->id)]) }}?tab=profile" method="POST" style="display:inline-block;">
																									{{ csrf_field() }}
																									<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i></button>
																							</form>
		                                            <form action="{{ route('superadmin.company.delete', ['company' => $company->id]) }}" method="POST" style="display:inline-block;">
		                                                {{ csrf_field() }}
		                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
		                                            </form>

		                                        @endif
		                                   </td>
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
				$('select').on('change', function (e) {
					var optionSelected = $("option:selected", this);
					var company_id = $('option:selected', this).attr('companyId');
					var valueSelected = this.value;
					if(confirm('You want to change the status of company?')){
						var valueSelected = (valueSelected == "0") ? "1" : "0";
						$.ajax({
								url: "{{route('superadmin.company.changecompanystatus')}}",
								type: "POST",
								data: {'company_id': company_id,'valueSelected':valueSelected,'_token': '{{ csrf_token() }}'},
								async: false,
								success: function (data) {
									alert('Company Status Changed Successfully');
									location.reload();
								}
						});
					}
				});

    });

    </script>
@endsection
