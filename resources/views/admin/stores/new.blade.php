@extends('layouts.admin')
@section('title')
	New Store
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Store</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create New Store
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
                    <form action="{{ route('admin.stores.save') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                            <input class="form-control" type="text" name="title" placeholder="Title" value="{{ old('title') }}" required>
                            <br>
                            <input class="form-control" type="text" name="slug" placeholder="Slug" value="{{ old('slug') }}">
                            <br>
                            <textarea name="description" id="wysi" class="form-control" placeholder="Product description">
                                {{ old('description') }}
                            </textarea>
                            <br>

                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <input class="form-control" type="text" name="url" placeholder="URL" value="{{ old('url') }}">
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