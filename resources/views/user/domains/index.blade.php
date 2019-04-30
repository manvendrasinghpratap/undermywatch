@extends('layouts.newadmintemplate')
@section('content')
<!-- Main section Start-->
<section class="section-container">
	 <!-- Page content-->
	 <div class="content-wrapper">
			<div class="content-heading">
				 <div>Domains</div>
				 <!-- START Language list-->
			</div>
			<div class="row">
				@include('admin.components.statuses')
				 <div class="col-lg-12">
				 <div class="card card-default">
				 <div class="card-body">
					 <form method="POST" action="{{ route('user.domains.create') }}">
							 {{ csrf_field() }}
							 <div class="form-row align-items-center">
									<div class="col-lg-3"><label class="sr-only" for="inlineFormInput">Enter Domain</label>
										<input class="form-control" name="domain" value="{{ old('domain') }}" placeholder="Domain (without scheme) ex: xyz.com">
									</div>
									<div class="col-lg-3"><label class="sr-only" for="inlineFormInput">Enter Notes</label><input class="form-control" name= "note" id="inlineFormInput" type="text" placeholder="Enter Notes" style="height: 2.375rem;"></div>
									<div class="col-lg-3">
										 <button class="btn btn-success" type="submit" style="width: 100%;">Add Domain</button>
									</div>
							 </div>
						</form>
				 </div>
			</div>
	 </div>
				 <div class="col-lg-12">
						<div class="panel panel-default">
							 <div class="panel-body">
									<div class="table-responsive">
									<table width="100%" class="table table-striped table-bordered table-hover datatable1">
										 <thead>
												<tr>
													 <th>Domain Name</th>
													 <th style="text-align:right;">Status</th>
													 <th>Links</th>
													 <th>Type</th>
													 <th class="sort-numeric">Clicks</th>
													 <th>Actions</th>
													 <th>Notes</th>
													 <th>Creator</th>
													 <th>Date Added</th>
												</tr>
										 </thead>
										 <tbody>
											 @foreach($domains as $domain)
													 <tr>
																 <td>{{ $domain->domain }}</td>
																 <td><center><i class="fa fa-circle success-circle"></i></center></td>
																 <td>{{ @$domain->links->count() }}</td>
																 <td>@if($domain->is_public==0) Public @else Private @endif</td>
																 <td>{{$domain->links->sum('clicks')}}</td>
															 <td>
																 @if($domain->enable_log)
																 <form action="{{ route('user.domains.disablelog', ['domain' => $domain->id]) }}" method="POST" style="display:inline-block;">
																 {{ csrf_field() }}
																 <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-link"></i></button>
																 </form>
																 @else
																 <form action="{{ route('user.domains.enablelog', ['domain' => $domain->id]) }}" method="POST" style="display:inline-block;">
																 {{ csrf_field() }}
																 <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-link"></i></button>
																 </form>
																 @endif

																		 <a href="{{ route('user.logs.domain', ['domain'=> $domain->id]) }}" class="btn btn-secondary btn-xs"><i class="fa fa-times-circle"></i></a>
																		 <a href="{{ route('user.logs.domain', ['domain'=> $domain->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
																		 @if(Auth::user()->id == @$domain->addedby->id)
																				 <form action="{{ route('user.domains.delete', ['domain' => $domain->id]) }}" method="POST" style="display:inline-block;">
																				 {{ csrf_field() }}
																				 <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
																				 </form>
																		 @endif
															 </td>
															 <td>
																	 <form action="{{ route('user.domains.update', ['domain' => $domain->id]) }}" method="POST">
																			 {{ csrf_field() }}
																			 <div class="input-group"><input class="form-control domain-edit-input" type="text" name="note" placeholder="Enter Notes" value ="{{ $domain->note }}">
			                                  <div class="input-group-append"><button type="submit" title="Delete Campaign" class="btn btn-secondary btn-xs domain-edit-btn"><i class="fa fa-save"></i></button></div>
			                               </div>
																	 </form>
															 </td>
															 <td>{{ @$domain->addedby->name }}</td>
															 <td>{{ @$domain->created_at->format(config('app.dateformat')) }}</td>
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
<!-- Main section End-->
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
