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
                    <form action="{{ route('admin.products.save') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="title" placeholder="Title" value="{{ old('title') }}" required>
                            <br>
                            <input class="form-control" type="text" name="slug" placeholder="Slug" value="{{ old('slug') }}">
                            <br>
                            <input class="form-control" type="text" name="subtitle" placeholder="Sub Title" value="{{ old('subtitle') }}">
                            <br>
                            <textarea name="description" id="wysi" class="form-control" placeholder="Product description">
                                {{ old('description') }}
                            </textarea>
                            <br>
                            @foreach($stores as $store)
                                <div class="row">
                                    <div class="col-sm-4">
                                       @if(!empty($store->image)) <img src="{{ asset('uploads/stores/'.$store->image) }}" class="img-responsive" style="max-height:50px;display: inline-block;"> @endif <span style="display: inline-block;">{{ $store->title }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="store[{{ $store->id }}][url]" class="form-control" placeholder="URL">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="store[{{ $store->id }}][price]" class="form-control" placeholder="price">
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                            
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <input class="form-control" type="text" name="brand" placeholder="Brand" value="{{ old('brand') }}">
                            <br>
                            <input class="form-control" type="number" name="reviews" value="{{ old('reviews') }}" placeholder="Reviews">
                            <br>
                            <input class="form-control" type="number" name="rating" value="{{ old('rating') }}" placeholder="Rating" step="0.01">
                            <br>
                            <select class="form-control" name="categories[]" multiple>
                                <option value="">-- None --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @if(!empty($cat->subcategories))
                                        @foreach($cat->subcategories as $c_child)
                                            <option value="{{ $c_child->id }}">--- {{ $c_child->title }}</option>
                                        @endforeach
                                        @if(!empty($c_child->subcategories))
                                            @foreach($c_child->subcategories as $cc_child)
                                                <option value="{{ $cc_child->id }}">--- {{ $cc_child->title }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                            <br>
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            <br>
                            <button class="btn btn-success" type="submit">Save</button>

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