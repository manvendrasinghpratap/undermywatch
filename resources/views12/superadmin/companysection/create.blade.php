@extends('layouts.newadmintemplate')
@section('content')
  <section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Edit: {{ @$companyDetails['company_name'] }}'s Settings</div><!-- START Language list-->
					 <div class="ml-auto">
							<button class="btn btn-labeled btn-success" type="button"><a href="{{ route('superadmin.company.section') }}" class="btn-label"><i class="fa fa-list"></i></a>List of Companies and Shield</button>
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
												 <form action="{{ route('superadmin.companysection.section', ['company' => base64_encode($companyDetails['id'])]) }}" method="POST">
		 												{{ csrf_field() }}
		 												<input type="hidden" name="company_id"  value="{{base64_encode($companyDetails['id'])}}"/>
		 												<div class="col-lg-12 col-sm-12 col-xs-12">
		 														<label>Assigned Sections</label>
		 														<br>
		 														<div class="col-lg-12 col-sm-12 col-xs-12">
																	<div style="padding-bottom:10px;">
		 																<select class="form-control" name="sections[]" id="sections" multiple style="height: auto;min-height: 150px;">
		 																		@foreach($sections as $section)
		 																				<option value="{{ $section->id }}" @if(in_array($section->id,$selectSectionArray)) selected="true" @endif>{{ $section->name }}</option>
		 																		@endforeach
		 																</select>
																	</div>
		 																<div class="pull-right">
		 																		<a onclick="select_all();">Select All</a> | <a onclick="deselect_all();">Deselect All</a>
		 																	</div>
		 														</div>
		 														<div class="col-lg-12 col-sm-12 col-xs-12">
		 																<br>
		 																<span class="pull-right">
		 																		<button class="btn btn-success right" type="submit">Update</button>
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
    $("#sections option").prop("selected", "selected");
  }
  function deselect_all(){
    $("#sections option:selected").removeAttr("selected");
  }
</script>

@endsection
