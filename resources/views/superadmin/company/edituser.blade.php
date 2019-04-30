@extends('layouts.newadmintemplate')
@section('content')
  <section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Users</div><!-- START Language list-->
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
                         <form method="POST" action="{{ route('superadmin.company.updateUser') }}" aria-label="{{ __('Update') }}">
                          @csrf
                          <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}"/>
                          <div class="form-group"><label>Name <span class='require'>*</span></label>
                            <input id="name" required type="text" placeholder="Name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                          </div>
                          <div class="form-group"><label>{{ __('E-Mail Address') }} <span class='require'>*</span></label>
                            <input autocomplete = "false" placeholder="{{ __('E-Mail Address') }}" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                          </div>
                          <div class="form-group"><label>{{ __('Company Name') }} <span class='require'>*</span></label>
                            <select class="form-control is_public company_status" name="company_id" id="company_id">
                              @foreach($companyDataArray as $key=>$value)
                                <option value = "{{$value['id'] }}" @if($user->company_id== $value['id']) selected="true"  @endif >{{$value['company_name']}}</option>
                              @endforeach
                            </select>

                            @if ($errors->has('company_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company_id') }}</strong>
                                </span>
                            @endif
                          </div>
                          <div class="form-group"><label>{{ __('User Type') }} <span class='require'>*</span></label>
                            <select class="form-control is_public company_status" name="level" id="level">
                              @foreach($usertypeArray as $key=>$value)
                                <option value = "{{$key}}" @if($user->level== $key) selected="true"  @endif >{{$value}}</option>
                              @endforeach
                            </select>

                            @if ($errors->has('level'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('level') }}</strong>
                                </span>
                            @endif
                          </div>
                          <div class="form-group"><label>Notes</label><input class="form-control" type="text" placeholder="Enter any notes" name="notes" value= "{{$user->notes}}" ></div>
                          <div class="form-group" style="display:none;"><label>Add Thumbnail</label><input class="form-control filestyle" type="file" data-classbutton="btn btn-secondary" data-classinput="form-control inline" data-icon="<span class='fa fa-upload mr-2'></span>">
                          </div>
                          <div class="form-group right">
                                  <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.min.css') }}">
<script type="text/javascript" src="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script type="text/javascript">
    $('#wysi').wysihtml5();
</script>
@endsection
