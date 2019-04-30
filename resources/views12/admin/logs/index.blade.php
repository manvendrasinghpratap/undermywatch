@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Logs</div><!-- START Language list-->
				</div>
				<div class="row">
					 <div class="col-lg-12">
							<div class="panel panel-default">
								 <div class="panel-body">
										<div class="table-responsive">
											<table width="100%" class="table table-striped table-bordered table-hover datatable1">
												<thead>
 													 <tr>
 															 <th>Log</th>
 															 <th>Size</th>
 															 <th>Action</th>
 													 </tr>
 											 </thead>
											 <tbody>
												 @foreach($logs as $log)
														 <tr>
																	<td>{{ $log['path'] }}</td>
																	<td>{{ $log['size'] }}</td>
																	<td>
																				<a href="{{ route('admin.logs.delete', ['log'=> $log['path']]) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
																				<a href="{{ route('admin.logs.show', ['log'=> $log['path']]) }}" target="__blank" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
																				<a href="{{ route('admin.logs.downloadcsv', ['log'=> $log['path']]) }}" target="__blank" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a>
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
    });

    </script>
@endsection
