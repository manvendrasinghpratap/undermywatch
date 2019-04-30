@extends('layouts.admin')
@section('title')
	Domains
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Domains</h1>
    </div>
</div>
<div class="row">
    @include('admin.components.statuses')
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Domains
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="row">
                            <form method="POST" action="{{ route('user.domains.create') }}">
                                {{ csrf_field() }}
                                <div class="col-sm-7">
                                    <input class="form-control" name="domain" value="{{ old('domain') }}" placeholder="Domain (without scheme) ex: xyz.com">
                                    </div>
                                    <div class="col-sm-2" style="display:none;">
                                    <select  class="form-control is_public" name="is_public">
                                    <option value="0"  >Public</option>
                                    <option value="1" selected = true>Private</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="submit" class="btn btn-danger" value="Add Domain">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <br>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Added By</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($domains as $domain)
	                            <tr>
                                    <td>{{ $domain->domain }}</td>
                                    <td>{{ $domain->addedby->name }}</td>
                                    <td>
                                        <form action="{{ route('user.domains.update', ['domain' => $domain->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="input-group">
                                                <textarea class="form-control" name="note">{{ $domain->note }}</textarea>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">
                                                       <i class="fa fa-check"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td>@if($domain->is_public==0) Public @else Private @endif</td>
	                                <td>
                                        @if(Auth::user()->id == $domain->addedby->id || Auth::user()->level > 1)
                                            <form action="{{ route('user.domains.delete', ['domain' => $domain->id]) }}" method="POST" style="display:inline-block;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                        @if($domain->enable_log)
                                            <form action="{{ route('user.domains.disablelog', ['domain' => $domain->id]) }}" method="POST" style="display:inline-block;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-ban"></i></button>
                                            </form>
                                        @else
    	                                	<form action="{{ route('user.domains.enablelog', ['domain' => $domain->id]) }}" method="POST" style="display:inline-block;">
    	                                		{{ csrf_field() }}
    	                                		<button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check-double"></i></button>
    	                                	</form>
                                        @endif
                                        <a href="{{ route('user.logs.domain', ['domain'=> $domain->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
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
