@extends('layouts.admin')
@section('title')
	New Category
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Category</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create New Category
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
                    <form action="{{ route('admin.categories.save') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="title" placeholder="Title" value="{{ old('title') }}" required>
                            <br>
                            <input class="form-control" type="text" name="slug" value="{{ old('slug') }}" placeholder="Slug">
                            <br>
                            <textarea name="description" id="wysi" class="form-control" placeholder="Product description">
                                {{ old('description') }}
                            </textarea>
                            <br>

                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            <br>
                            <label>Parent Category</label>
                            <br>
                            <select class="form-control" name="parent">
                                <option value="">-- None --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @if(!empty($cat->subcategories))
                                        @foreach($cat->subcategories as $c_child)
                                            <option value="{{ $c_child->id }}">--- {{ $c_child->title }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            <br>
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