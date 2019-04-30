@extends('layouts.admin')
@section('title')
    New User
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Company Details</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        @include('admin.components.statuses')
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create New Company
                </div>
                <div class="panel-body">
                  <div class="form-group {{ $errors->has('companyname') ? 'has-error' : '' }} control-required">
                  <form method="POST" action="{{ route('superadmin.company.update',['company' => base64_encode($companyDetails->id)]) }}">
                      @csrf
                      <div class="form-group row">
                          <label for="companyname" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label>
                          <div class="col-md-6">
                              <input id="companyname" required type="text" class="form-control{{ $errors->has('companyname') ? ' is-invalid' : '' }}" name="companyname" value="{{ $companyDetails->company_name }}" required autofocus>

                              @if ($errors->has('companyname'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('companyname') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Company E-Mail Address') }}</label>

                          <div class="col-md-6">
                              <input autocomplete = "false" id="company_email" type="email" class="form-control{{ $errors->has('company_email') ? ' is-invalid' : '' }}" name="company_email" value="{{ $companyDetails->company_email }}" required>

                              @if ($errors->has('company_email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('company_email') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="contact_person" class="col-md-4 col-form-label text-md-right">{{ __('Contact Person') }}</label>
                          <div class="col-md-6">
                              <input id="contact_person" required type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" value="{{ $companyDetails->contact_person }}" name="contact_person" required>

                              @if ($errors->has('contact_person'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('contact_person') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="contact_no" class="col-md-4 col-form-label text-md-right">{{ __('Contact No.') }}</label>
                          <div class="col-md-6">
                              <input id="contact_no" maxlength="10" autocomplete="false" required type="text" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" value="{{ $companyDetails->contact_no }}" name="contact_no" required onkeypress="return isNumber(event)" >
                              @if ($errors->has('contact_no'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('contact_no') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="company_address" class="col-md-4 col-form-label text-md-right">{{ __('Contact Address') }}</label>
                          <div class="col-md-6">
                              <input id="company_address" required type="text" class="form-control{{ $errors->has('company_address') ? ' is-invalid' : '' }}" value="{{ $companyDetails->company_address }}" name="company_address" required>
                              @if ($errors->has('company_address'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('company_address') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Add Company') }}
                              </button>
                          </div>
                      </div>
                  </form>
                </div>
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
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>

@endsection
