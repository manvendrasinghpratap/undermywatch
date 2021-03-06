@extends('layouts.admin')
@section('title')
	Logs
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Logs</h1>
    </div>
</div>
<div class="row">
    @include('user.components.statuses')
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Logs
                </div>
                <div class="panel-body">
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
                                        <a href="{{ route('user.logs.delete', ['log'=> $log['path']]) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>

																				<a href="{{ route('user.logs.show', ['log'=> $log['path']]) }}" target="__blank" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('user.logs.downloadcsv', ['log'=> $log['path']]) }}" target="__blank" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a>
                                	</td>
	                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset("assets/vendor/datatables/js/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("assets/vendor/datatables-plugins/dataTables.bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/vendor/datatables-responsive/dataTables.responsive.js")}}"></script>
    <script>
    $(document).ready(function() {
        $('.datatable1').DataTable({
            responsive: true
        });
    });
    </script>
@endsection
