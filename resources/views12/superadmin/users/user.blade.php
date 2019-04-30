@extends('layouts.newadmintemplate')
@section('style')
	<style>
	.setcolorP_{
		background-color: #1b72e2;
	}
	</style>
@endsection
@section('content')
  <section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>User ( {{ $user->name }} ) section Settings</div><!-- START Language list-->
					 <div class="ml-auto">
							<button class="btn btn-labeled btn-success" type="button"><a href="{{ route('superadmin.users.index') }}" class="btn-label"><i class="fa fa-list"></i></a>List of User</button>
					 </div><!-- END Language list-->
				</div>
				<div class="row">
              @include('admin.components.statuses')
					 <div class="col-lg-12">
							<div class="panel panel-default">
                <div class="panel-body">
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} control-required">
                    <div class="card card-default">
                       <div class="card-body">
														<div class="row" style="margin-bottom:30px;">
																<div class="col-sm-3">Company Name : {{$user->companyname->company_name}}</div>
																<div class="col-sm-6">Level : {{ $user->levelname->level_name}}</div>
														</div>

														<form action="{{ route('superadmin.users.section', ['user' => $user->id]) }}" method="POST">
																{{ csrf_field() }}
																<div class="">
																		<label>Assigned Sections</label>
																		<br>
																		<div class="col-lg-12 col-sm-12 col-xs-12">
																				<select class="form-control" name="sections[]" id="sections" multiple="true" style="height: auto;min-height: 150px;">
																						@foreach($sections as $section)
																								<option value="{{ $section->id }}" @if(!empty($user->sections) && !empty($user->sections->where('id', $section->id)->first())) selected @endif>{{ $section->name }}</option>
																						@endforeach
																				</select>
																				<span class="pull-right">
																						<a onclick="select_all();">Select All</a> | <a onclick="deselect_all();">Deselect All</a>
																					</span>
																		</div>
																		<div class="col-lg-12 col-sm-12 col-xs-12">
																				<br>
																				<span class="pull-right">
																						<button class="btn btn-success" type="submit">Update</button>
																				</span>
																		</div>
																</div>
														</form>
                        </div>


                  </div>
                </div>
							</div>
					 </div>
				</div>
		 </div>
	</section>

@endsection


@section('scripts')
<script type="text/javascript">
  function select_all(){
    $("#sections option").prop("selected", "selected").addClass('setcolor');
  }
  function deselect_all(){
    $("#sections option:selected").removeAttr("selected");
  }

</script>

@endsection
