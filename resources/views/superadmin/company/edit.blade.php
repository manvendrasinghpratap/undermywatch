@extends('layouts.newadmintemplate')
@section('content')
  @php
  $active = 'profile';
  if(Request::get('tab')=='profile')
  $active = 'profile';
  elseif(Request::get('tab')=='account')
  $active = 'account';
  elseif(Request::get('tab')=='shield')
  $active = 'shield';
  elseif(Request::get('tab')=='campaign')
  $active = 'campaign';
  else
  $active = 'profile';
@endphp
  <section class="section-container">
          <!-- Page content-->
          <div class="content-wrapper">
             <div class="content-heading">
                <div>{{ $companyDetails->company_name }} <small>{{ $companyDetails->company_email }}</small></div><!-- START Language list-->

                <div class="ml-auto" style="margin-top: -21px;">
                     <a href="https://dashboard.viralsparks.com/user/726mediallc/reports" class="btn btn-default btn-lg dash-navi"><em class="fa fa-rainbow success-circle"></em> Dashboard</a>
                     <a href="{{route('superadmin.companiescection.campaign',['userId' => base64_encode(@$companyDetails->id)])}}" class="btn btn-default btn-lg dash-navi"><em class="fa fa-mask success-circle"></em> Campaigns</a>
                     <a href="{{ route('admin.stats.companystatssuperadmin', ['company' => base64_encode($companyDetails->id)]) }}?tab=shield" class="btn btn-default btn-lg dash-navi"><em class="fa fa-chart-line success-circle"></em> Reports</a> 
                     <a href="{{ route('superadmin.company.edit', ['company' => base64_encode($companyDetails->id)]) }}?tab=shield" class="btn btn-default btn-lg dash-navi"><em class="fa fa-user-ninja success-circle"></em> Profile</a>
                </div>
             </div>

             <div class="row">
                   <div class="col-lg-3">
                      <div class="card b">
                         <div class="card-header bg-gray-lighter text-bold">Campany Settings</div>
                         <div class="list-group"><a class="list-group-item list-group-item-action @if($active=='profile') active @endif" href="#tabSetting1" data-toggle="tab">Company Profile</a><a class="list-group-item list-group-item-action @if($active=='account') active @endif" href="#tabSetting2" data-toggle="tab">Account</a><a class="list-group-item list-group-item-action @if($active=='shield') active @endif" href="#tabSetting5" data-toggle="tab">Shields</a></div>
                      </div>
                   </div>
                   <div class="col-lg-9">
                      <div class="tab-content p-0 b0">
                         <div class="tab-pane @if($active=='profile') active @endif" id="tabSetting1">
                            <div class="card b">
                               <div class="card-header bg-gray-lighter text-bold">Company Profile</div>
                               <div class="card-body">
                                 <form method="POST" action="{{ route('superadmin.company.update',['company' => base64_encode($companyDetails->id)]) }}">
                                     @csrf

                                     <div class="form-group"><label>{{ __('Company Name') }} <span class='require'>*</span></label>
                                       <input id="companyname" required type="text" class="form-control{{ $errors->has('companyname') ? ' is-invalid' : '' }}" name="companyname" value="{{ $companyDetails->company_name }}" required autofocus>
                                       @if ($errors->has('companyname'))
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('companyname') }}</strong>
                                           </span>
                                       @endif
                                     </div>
                                     <div class="form-group"><label>{{ __('Company E-Mail Address') }} <span class='require'>*</span></label>
                                       <input autocomplete = "false" id="company_email" type="email" class="form-control{{ $errors->has('company_email') ? ' is-invalid' : '' }}" name="company_email" value="{{ $companyDetails->company_email }} {{ old('company_email') }}" required>
                                       @if ($errors->has('company_email'))
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('company_email') }}</strong>
                                           </span>
                                       @endif
                                     </div>
                                     <div class="form-group"><label>{{ __('Contact Person') }} <span class='require'>*</span></label>
                                     <input id="contact_person"  value = "{{ $companyDetails->contact_person }}" required type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" required>

                                       @if ($errors->has('contact_person'))
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('contact_person') }}</strong>
                                           </span>
                                       @endif
                                     </div>
                                     <div class="form-group"><label>{{ __('Contact No.') }} <span class='require'>*</span></label>
                                     <input id="contact_no" maxlength="10" autocomplete="false" required type="text" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" name="contact_no" required onkeypress="return isNumber(event)" value="{{ $companyDetails->contact_no }}" >
                                       @if ($errors->has('contact_no'))
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('contact_no') }}</strong>
                                           </span>
                                       @endif
                                     </div>
                                     <div class="form-group"><label>{{ __('Contact Address') }} <span class='require'>*</span></label>
                                     <input id="company_address" value="{{ $companyDetails->company_address }}" required type="text" class="form-control{{ $errors->has('company_address') ? ' is-invalid' : '' }}" name="company_address" required>
                                       @if ($errors->has('company_address'))
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('company_address') }}</strong>
                                           </span>
                                       @endif
                                     </div>

                                     <div class="form-group right_">
                                             <button type="submit" class="btn btn-success">{{ __('Update Settings') }}</button>
                                     </div>
                                 </form>

                               </div>
                            </div>
                         </div>
                         <div class="tab-pane @if($active=='account') active @endif" id="tabSetting2">
                            <div class="card b">
                               <div class="card-header bg-grey text-bold">Company Status</div>
                               <div class="card-body bt">
                                  <div class="row">
                                   <div class="form-group col-lg-6">
                                        <div class="input-group">
                                  <div class="input-group-prepend"><span class="input-group-text">Status</span></div><input class="form-control" type="text" value="Active" disabled>
                                  <div class="input-group-append"><button class="btn btn-labeled btn-danger" type="button"><span class="btn-label"><i class="fa fa-dizzy"></i></span>Disable Company</button></div>
                               </div>
                                  </div>
                               </div>
                               </div>
                            </div>
                         </div>
                         <div class="tab-pane @if($active=='shield') active @endif" id="tabSetting5">
                            <div class="card b">
                               <div class="card-header bg-gray-lighter text-bold">Active Shields</div>
                               <div class="card-body">
                                  <div class="list-group">
                                    @php $sectionsArray[] = array(); @endphp
                                    @if(count($companyDetails->sections)>0)
                                      @foreach($companyDetails->sections as $section)
                                        @php $sectionsArray[] = $section['id'] @endphp
       																<div class="list-group-item d-flex align-items-center">
       																	<?php	if($section['image']==''){
       																			$imagename= 'default.jpg';
       																		}elseif(file_exists('storage/'.$section['image'])){
       																			$imagename= $section['image'];
       																		}else{
       																			$imagename= 'default.jpg';
       																		}
       																		 ?>
       																		 <img class="shield-img" src="{{url('storage/'.$imagename)}}" alt="" style="width: 150px;height: 80px;">
       																	 <div style="padding-left: 150px;">
       																			<p class="text-bold mb-0">{{@$section['name']}}</p><small>{{@$section['slug']}}</small>
       																	 </div>
       																	 <div class="ml-auto">
       																		 <form method="post" action="{{route('superadmin.companysetting.deleteCompanySection',[base64_encode($section['id']),'&?tab=shield'])}}">
       																			 <input type="hidden" name="company_id" value="{{base64_encode($companyDetails['id'])}}">
       																			 <input type="hidden" name="section_id" value="{{base64_encode($section['id'])}}">
       																			 <button class="btn btn-warning" type="submit"> <strong>Revoke</strong> </button>
       																	 </form>
       																	 </div>
       																</div>
                                      @endforeach
                                    @endif
                                  </div>
                               </div>
                            </div>
                            <div class="card b">
                               <div class="card-header bg-grey text-bold">InActive Shields</div>
                               <div class="card-body">
                                  <div class="list-group">
                                    @if(count($sections)>0)
                                      @foreach($sections as $section)
                                        @php if (!in_array($section['id'], $sectionsArray)) {  @endphp
       																<div class="list-group-item d-flex align-items-center">
       																	<?php	if($section['image']==''){
       																			$imagename= 'default.jpg';
       																		}elseif(file_exists('storage/'.$section['image'])){
       																			$imagename= $section['image'];
       																		}else{
       																			$imagename= 'default.jpg';
       																		}
       																		 ?>
       																		 <img class="shield-img" src="{{url('storage/'.$imagename)}}" alt="" style="width: 150px;height: 80px;">
       																	 <div style="padding-left: 150px;">
       																			<p class="text-bold mb-0">{{@$section['name']}}</p><small>{{@$section['slug']}}</small>
       																	 </div>
       																	 <div class="ml-auto">
       																		 <form method="post" action="{{route('superadmin.companysetting.assigncompanysection',[base64_encode($section['id']),'&?tab=shield'])}}">
       																			 <input type="hidden" name="company_id" value="{{base64_encode($companyDetails['id'])}}">
       																			 <input type="hidden" name="section_id" value="{{base64_encode($section['id'])}}">
       																			 <button class="btn btn-warning" type="submit"> <strong>Revoke</strong> </button>
       																	 </form>
       																	 </div>
       																</div>
                                      @php	} @endphp
                                      @endforeach
                                    @endif
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
          </div>
       </section>
@endsection
@section('content_')
  <section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Edit Company Details</div><!-- START Language list-->
					 <div class="ml-auto">
							<button class="btn btn-labeled btn-success" type="button"><a href="{{ route('superadmin.company.index') }}" class="btn-label"><i class="fa fa-list"></i></a>List of Companies</button>
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
                         <form method="POST" action="{{ route('superadmin.company.update',['company' => base64_encode($companyDetails->id)]) }}">
                             @csrf

                             <div class="form-group"><label>{{ __('Company Name') }} <span class='require'>*</span></label>
                               <input id="companyname" required type="text" class="form-control{{ $errors->has('companyname') ? ' is-invalid' : '' }}" name="companyname" value="{{ $companyDetails->company_name }}" required autofocus>
                               @if ($errors->has('companyname'))
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('companyname') }}</strong>
                                   </span>
                               @endif
                             </div>
                             <div class="form-group"><label>{{ __('Company E-Mail Address') }} <span class='require'>*</span></label>
                               <input autocomplete = "false" id="company_email" type="email" class="form-control{{ $errors->has('company_email') ? ' is-invalid' : '' }}" name="company_email" value="{{ $companyDetails->company_email }} {{ old('company_email') }}" required>
                               @if ($errors->has('company_email'))
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('company_email') }}</strong>
                                   </span>
                               @endif
                             </div>
                             <div class="form-group"><label>{{ __('Contact Person') }} <span class='require'>*</span></label>
                             <input id="contact_person"  value = "{{ $companyDetails->contact_person }}" required type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" required>

                               @if ($errors->has('contact_person'))
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('contact_person') }}</strong>
                                   </span>
                               @endif
                             </div>
                             <div class="form-group"><label>{{ __('Contact No.') }} <span class='require'>*</span></label>
                             <input id="contact_no" maxlength="10" autocomplete="false" required type="text" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" name="contact_no" required onkeypress="return isNumber(event)" value="{{ $companyDetails->contact_no }}" >
                               @if ($errors->has('contact_no'))
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('contact_no') }}</strong>
                                   </span>
                               @endif
                             </div>
                             <div class="form-group"><label>{{ __('Contact Address') }} <span class='require'>*</span></label>
                             <input id="company_address" value="{{ $companyDetails->company_address }}" required type="text" class="form-control{{ $errors->has('company_address') ? ' is-invalid' : '' }}" name="company_address" required>
                               @if ($errors->has('company_address'))
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('company_address') }}</strong>
                                   </span>
                               @endif
                             </div>
                             <div class="form-group right">
                                     <button type="submit" class="btn btn-primary">
                                         {{ __('Update Company') }}
                                     </button>
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





@section('content_')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Company</h1>
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
                  <form method="POST" action="{{ route('superadmin.company.store') }}" aria-label="{{ __('Register') }}">
                      @csrf
                      <div class="form-group row">
                          <label for="companyname" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label>
                          <div class="col-md-6">
                              <input id="companyname" required type="text" class="form-control{{ $errors->has('companyname') ? ' is-invalid' : '' }}" name="companyname" value="{{ old('companyname') }}" required autofocus>

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
                              <input autocomplete = "false" id="company_email" type="email" class="form-control{{ $errors->has('company_email') ? ' is-invalid' : '' }}" name="company_email" value="{{ old('company_email') }}" required>

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
                              <input id="contact_person" required type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" required>

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
                              <input id="contact_no" maxlength="10" autocomplete="false" required type="text" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" name="contact_no" required onkeypress="return isNumber(event)" >
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
                              <input id="company_address" required type="text" class="form-control{{ $errors->has('company_address') ? ' is-invalid' : '' }}" name="company_address" required>
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



@section('content_')
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
