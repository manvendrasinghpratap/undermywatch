@extends('layouts.admin')
@section('title')
	Categories
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Categories</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Categories
                </div>
                <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-12">
                            <div class="statuses">
                            @if(session('status'))
                               <div class="alert alert-success">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>Success!</strong> {{ session('status') }}
                               </div>
                            @endif
                            @if(session('error'))
                               <div class="alert alert-warning">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>Error!</strong> {{ session('error') }}
                               </div>
                            @endif
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('admin.categories.new') }}"><i class="fa fa-plus">&nbsp;</i>New Category</a>
                        </div>
                        <br>
                        <hr>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Parent</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($categories as $category)
	                            <tr>
	                                <td>{{ $category->id }}</td>
                                    <td>@if(!empty($category->parent)){{ $category->parent->title }} @else - @endif</td>
	                                <td>{{ $category->title }}</td>
	                                <td>
	                                	<a class="btn btn-xs btn-primary" href="{{ route('admin.category.category', ['category' => $category->slug]) }}"><i class="fa fa-pencil"></i></a>
	                                	<form action="{{ route('admin.category.delete', ['category' => $category->slug]) }}" method="POST" style="display:inline-block;">
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