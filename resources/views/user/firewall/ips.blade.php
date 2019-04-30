@extends('layouts.admin')
@section('title')
	Blocked ISPs
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blocked IPs</h1>
    </div>
</div>
<div class="row">
    @include('user.components.statuses')
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Blocked IPs
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="row">
                            <form method="POST" action="{{ route('user.firewall.addips') }}">
                                {{ csrf_field() }}
                                <div class="col-sm-4">
                                    <input class="form-control" name="start" value="{{ old('start') }}" placeholder="IP Start Range (IPV4)">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control" name="end" placeholder="IP End Range (If Any)">
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-danger" value="Block IP Range">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <br>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>
                                <th>Start</th>
                                <th>End</th>
                                <th>Repetition</th>
                                <th>Block Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($ips as $ip)
	                            <tr>
                                    <td>{{ long2ip((int)$ip->start) }}</td>
	                                <td>{{ long2ip((int)$ip->end) }}</td>
                                    <td>{{ $ip->repetition }}</td>
                                    <td>@if($ip->is_permanent) Permanent @else Temporary @endif</td>
	                                <td>
                                        @if($ip->is_permanent)
                                            <form action="{{ route('user.firewall.blocktemporary', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-xs btn-primary" disabled><i class="fa fa-lock-open">&nbsp;</i> Block Temporary</button>
                                            </form>
                                        @else
                                            <form action="{{ route('user.firewall.deleteip', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                            <form action="{{ route('user.firewall.blockpermanent', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-lock">&nbsp;</i> Block Permanently</button>
                                            </form>
                                        @endif
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
