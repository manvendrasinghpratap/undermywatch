@extends('layouts.admin')
@section('title')
	Products
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Products</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Products
                </div>
                <div class="col-sm-12">
                    <br>
                    <div class="pull-right">
                        <form>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-4">
                                <div class="input-group custom-search-form">
                                        <input type="text" name="q" class="form-control" placeholder="Search...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-success" href="{{ route('user.products.new') }}"><i class="fa fa-plus">&nbsp;</i>New Product</a>
                            </div>
                        </form>
                    </div>
                    <br>
                    <br>
                </div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Categories</th>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($products as $product)
	                            <tr>
	                                <td>{{ $product->id }}</td>
                                    <td>@if(!empty($product->image)) <img src="{{ asset('uploads/products/'.$product->image) }}" class="img-responsive" style="max-width: 100px !important; max-height: 100px !important;"> @endif <a class="" href="{{ route('user.product.product', ['product' => $product->slug]) }}">{{ $product->title }}</a></td>
                                    <td>@foreach($product->categories as $cat){{ $cat->title }}, @endforeach</td>
	                                <td>{{ $product->brand }}</td>
	                                <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('user.product.product', ['product' => $product->slug]) }}"><i class="fa fa-pencil"></i></a>
	                                	<a class="btn btn-xs btn-success" href="{{ route('user.product.duplicate', ['product' => $product->slug]) }}"><i class="fa fa-copy"></i></a>
	                                	<form action="{{ route('user.product.delete', ['product' => $product->slug]) }}" method="POST" style="display:inline-block;">
	                                		{{ csrf_field() }}
	                                		<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
	                                	</form>
                                	</td>
	                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center;">
                        {{ $products->appends(Request::only('q'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
