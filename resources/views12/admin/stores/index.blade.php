@extends('layouts.admin')
@section('title')
	Stores
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Stores</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Stores
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <br>
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('admin.stores.new') }}"><i class="fa fa-plus">&nbsp;</i>New Store</a>
                        </div>
                        <hr>
                        <br>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>
                                <th>Store ID</th>
                                <th>Store Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($stores as $store)
	                            <tr>
	                                <td>{{ $store->id }}</td>
	                                <td>{{ $store->title }}</td>
	                                <td>
	                                	<a class="btn btn-xs btn-primary" href="{{ route('admin.store.store', ['store' => $store->slug]) }}"><i class="fa fa-pencil"></i></a>
	                                	<form action="{{ route('admin.store.delete', ['store' => $store->slug]) }}" method="POST" style="display:inline-block;">
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