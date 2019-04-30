@extends('layouts.admin')
@section('title')
	Blocked ISPs
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blocked ISPs</h1>
    </div>
</div>
<div class="row">
    @include('user.components.statuses')
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Blocked ISPs
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="row">
                            <form method="POST" action="{{ route('user.firewall.addisp') }}">
                                {{ csrf_field() }}
                                <div class="col-sm-9">
                                    <input class="form-control" name="isp" placeholder="ISP">
                                </div>
                                <div class="col-sm-3">
                                    <input type="submit" class="btn btn-danger" value="Block ISP">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <br>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>
                                <th>ISP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($isps as $isp)
	                            <tr>
	                                <td>{{ $isp->isp }}</td>
	                                <td>
	                                	<form action="{{ route('user.firewall.deleteisp', ['isp' => $isp->id]) }}" method="POST" style="display:inline-block;">
	                                		{{ csrf_field() }}
	                                		<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
	                                	</form>
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
