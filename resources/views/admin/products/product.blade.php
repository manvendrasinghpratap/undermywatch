@extends('layouts.admin')
@section('title')
	New Product
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Product</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create New Product
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.product.product', ['product' => $product->slug]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="title" placeholder="Title" value="{{ $product->title }}" required>
                            <br>
                            <input class="form-control" type="text" name="slug" placeholder="Slug" value="{{ $product->slug }}">
                            <br>
                            <input class="form-control" type="text" name="subtitle" placeholder="Sub Title" value="{{ $product->subtitle }}">
                            <br>
                            <textarea name="description" id="wysi" class="form-control" placeholder="Product description">
                                {{ $product->description }}
                            </textarea>
                            <br>
                            @foreach($stores as $store)
                                <div class="row">
                                    <div class="col-sm-4">
                                       @if(!empty($store->image)) <img src="{{ asset('uploads/stores/'.$store->image) }}" class="img-responsive" style="max-height:50px;display: inline-block;"> @endif <span style="display: inline-block;">{{ $store->title }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="store[{{ $store->id }}][url]" class="form-control" value="@if(!empty($product->stores) && !empty($product->stores->where('id', $store->id)->first())){{$product->stores->where('id', $store->id)->first()->pivot->url}}@endif" placeholder="URL">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="store[{{ $store->id }}][price]" class="form-control" value="@if(!empty($product->stores) && !empty($product->stores->where('id', $store->id)->first())){{$product->stores->where('id', $store->id)->first()->pivot->price}}@endif" placeholder="price">
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                            
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <input class="form-control" type="text" name="brand" placeholder="Brand" value="{{ $product->brand }}">
                            <br>
                            <input class="form-control" type="number" name="reviews" value="{{ $product->reviews }}" placeholder="Reviews">
                            <br>
                            <input class="form-control" type="number" name="rating" value="{{ $product->rating }}" placeholder="Rating" step="0.01">
                            <br>
                            <select class="form-control" name="categories[]" multiple>
                                <option value="">-- None --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @if(!empty($product->categories) && !empty($product->categories->where('id', $cat->id)->first())) selected @endif>{{ $cat->title }}</option>
                                    @if(!empty($cat->subcategories))
                                        @foreach($cat->subcategories as $c_child)
                                            <option value="{{ $c_child->id }}" @if(!empty($product->categories) && !empty($product->categories->where('id', $c_child->id)->first())) selected @endif>--- {{ $c_child->title }}</option>
                                        @endforeach
                                        @if(!empty($c_child->subcategories))
                                            @foreach($c_child->subcategories as $cc_child)
                                                <option value="{{ $cc_child->id }}" @if(!empty($product->categories) && !empty($product->categories->where('id', $cc_child->id)->first())) selected @endif>--- {{ $cc_child->title }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                            <br>
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            @if(!empty($product->image)) 
                                <img class="img-responsive" src="{{ asset('uploads/products/'.$product->image) }}">
                            @endif
                            <br>
                            <button class="btn btn-success" type="submit">Update</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.min.css') }}">
<script type="text/javascript" src="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script type="text/javascript">
    $('#wysi').wysihtml5();
</script>
@endsection